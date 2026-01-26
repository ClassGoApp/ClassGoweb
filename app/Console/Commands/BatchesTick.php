<?php

namespace App\Console\Commands;

use App\Models\EmailBatch;
use App\Models\EmailBatchItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class BatchesTick extends Command
{
    protected $signature = 'batches:tick';
    protected $description = 'Envía emails por lotes desde email_batches/email_batch_items (tick cada minuto)';

    public function handle(): int
    {
        // 🔒 Lock fuerte MySQL (ideal en cron/cPanel para evitar ejecuciones dobles)
        $lockName = 'classgo_batches_tick';
        $gotLock = (int) (DB::selectOne("SELECT GET_LOCK(?, 0) AS l", [$lockName])->l ?? 0);

        if ($gotLock !== 1) {
            return self::SUCCESS;
        }

        try {
            return DB::transaction(function () {

                // 1) Si hay batches vencidos, cerrarlos primero (barato y evita ruido)
                EmailBatch::query()
                    ->whereIn('status', ['pending', 'running'])
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '<=', now())
                    ->update([
                        'status' => 'done',
                        'last_error' => 'expired',
                        'updated_at' => now(),
                    ]);


                // 2) Tomar el batch activo más antiguo, pero SOLO si está vigente
                /** @var EmailBatch|null $batch */
                $batch = EmailBatch::query()
                    ->whereIn('status', ['pending', 'running'])
                    ->whereNull('expires_at')
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->first();

                if (!$batch) {
                    $batch = EmailBatch::query()
                        ->whereIn('status', ['pending', 'running'])
                        ->where('expires_at', '>', now())
                        ->orderBy('id')
                        ->lockForUpdate()
                        ->first();
                }


                if (!$batch) {
                    return self::SUCCESS;
                }

                // 3) Seguridad extra: si justo expiró, cerrarlo
                if ($batch->expires_at && now()->greaterThanOrEqualTo($batch->expires_at)) {
                    $batch->update([
                        'status' => 'done',
                        'last_error' => 'expired',
                    ]);
                    return self::SUCCESS;
                }

                // 4) Pasar a running
                if ($batch->status === 'pending') {
                    $batch->update(['status' => 'running']);
                }

                // 5) Enviar hasta batch_size (tu caso: 1 por minuto)
                $toSend = max(1, (int) $batch->batch_size);
                $sentNow = 0;

                while ($sentNow < $toSend) {

                    /** @var EmailBatchItem|null $item */
                    // $item = EmailBatchItem::where('batch_id', $batch->id)
                    //     ->where('status', 'pending')
                    //     ->orderBy('position')
                    //     ->lockForUpdate()
                    //     ->first();

                    $item = EmailBatchItem::query()
                        ->where('batch_id', $batch->id)
                        ->where('status', 'pending')
                        ->orderBy('position')
                        ->lockForUpdate()
                        ->first();


                    if (!$item) {
                        // ya no hay pendientes
                        $batch->update(['status' => 'done']);
                        break;
                    }

                    // 6) email del tutor
                    $email = DB::table('users')
                        ->where('id', $item->user_id)
                        ->value('email');

                    if (!$email) {
                        $item->update([
                            'status' => 'failed',
                            'last_error' => 'User sin email',
                        ]);
                        $sentNow++;
                        continue;
                    }

                    // 7) enviar
                    try {
                        Mail::raw(
                            "Hola! ClassGo: tienes una invitación para la materia ID {$batch->subject_id}.",
                            fn($m) => $m->to($email)->subject("ClassGo | Invitación materia {$batch->subject_id}")
                        );

                        $item->update([
                            'status' => 'sent',
                            'sent_at' => now(),
                            'last_error' => null,
                        ]);

                        $batch->update([
                            'sent_count' => (int) $batch->sent_count + 1,
                        ]);
                    } catch (Throwable $e) {
                        $item->update([
                            'status' => 'failed',
                            'last_error' => $e->getMessage(),
                        ]);
                    }

                    $sentNow++;
                }

                return self::SUCCESS;
            });
        } finally {
            DB::select("SELECT RELEASE_LOCK(?)", [$lockName]);
        }
    }
}
