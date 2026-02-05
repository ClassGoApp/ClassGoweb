<?php

namespace App\Console\Commands;

use App\Models\EmailBatch;
use App\Models\EmailBatchItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;
use App\Mail\TutoriaInstanteNotificacionMail;

use Illuminate\Support\Str;


class BatchesTick extends Command
{

    // protected $signature = 'batches:tick';
    protected $signature = 'batches:tick {--batch_id=}';

    protected $description = 'Envía emails por lotes desde email_batches/email_batch_items (tick cada minuto)';

    // public function handle(): int
    // {
    //     $batchIdOpt = (int) ($this->option('batch_id') ?? 0);

    //     $lockName = $batchIdOpt > 0
    //         ? "classgo_batches_tick_batch_{$batchIdOpt}"
    //         : 'classgo_batches_tick';

    //     $gotLock = (int) (DB::selectOne("SELECT GET_LOCK(?, 0) AS l", [$lockName])->l ?? 0);
    //     if ($gotLock !== 1) return self::SUCCESS;

    //     try {
    //         // cerrar batches expirados
    //         EmailBatch::query()
    //             ->whereIn('status', ['pending', 'running'])
    //             ->whereNotNull('expires_at')
    //             ->where('expires_at', '<=', now())
    //             ->update([
    //                 'status' => 'done',
    //                 'last_error' => 'expired',
    //                 'updated_at' => now(),
    //             ]);

    //         // 1) reservar batch + items (TX corta)
    //         [$batch, $items] = DB::transaction(function () {

    //             $batch = EmailBatch::query()
    //                 ->whereIn('status', ['pending', 'running'])
    //                 ->whereNull('expires_at')
    //                 ->orderBy('id')
    //                 ->lockForUpdate()
    //                 ->first();

    //             if (!$batch) {
    //                 $batch = EmailBatch::query()
    //                     ->whereIn('status', ['pending', 'running'])
    //                     ->where('expires_at', '>', now())
    //                     ->orderBy('id')
    //                     ->lockForUpdate()
    //                     ->first();
    //             }

    //             // if (!$batch) {
    //             //     return [null, collect()];
    //             // }
    //             // if ($batch->expires_at && now()->greaterThanOrEqualTo($batch->expires_at)) {
    //             //     $batch->update(['status' => 'done', 'last_error' => 'expired']);
    //             //     return [null, collect()];
    //             // }

    //             // if ($batch->status === 'pending') {
    //             //     $batch->update(['status' => 'running']);
    //             // }

    //             // $toSend = max(1, (int)$batch->batch_size);

    //             // $items = EmailBatchItem::query()
    //             //     ->where('batch_id', $batch->id)
    //             //     ->where('status', 'pending')
    //             //     ->orderBy('position')
    //             //     ->lockForUpdate()
    //             //     ->limit($toSend)
    //             //     ->get();

    //             // // if ($items->isEmpty()) {
    //             // //     $batch->update(['status' => 'done']);
    //             // //     return [$batch, collect()];
    //             // // }


    //             // if ($items->isEmpty()) {
    //             //     // ✅ ya se enviaron todos, pero aún podemos recibir aceptaciones
    //             //     // No cerramos hasta expires_at
    //             //     $batch->update([
    //             //         'status' => 'running',
    //             //         'last_error' => 'all_sent_waiting_accepts',
    //             //         'updated_at' => now(),
    //             //     ]);
    //             //     return [$batch, collect()];
    //             // }
    //             // // reservar: pending -> sending
    //             // EmailBatchItem::query()
    //             //     ->whereIn('id', $items->pluck('id'))
    //             //     ->update([
    //             //         'status' => 'sending',
    //             //         'updated_at' => now(),
    //             //     ]);

    //             // return [$batch, $items];

    //             if (!$batch) {
    //                 return [null, collect()];
    //             }

    //             // expirado => cerrar
    //             if ($batch->expires_at && now()->greaterThanOrEqualTo($batch->expires_at)) {
    //                 $batch->update([
    //                     'status' => 'done',
    //                     'last_error' => 'expired',
    //                     'updated_at' => now(),
    //                 ]);
    //                 return [null, collect()];
    //             }

    //             // arrancar
    //             if ($batch->status === 'pending') {
    //                 $batch->update([
    //                     'status' => 'running',
    //                     'updated_at' => now(),
    //                 ]);
    //             }

    //             $toSend = max(1, (int) $batch->batch_size);

    //             $items = EmailBatchItem::query()
    //                 ->where('batch_id', $batch->id)
    //                 ->where('status', 'pending')
    //                 ->orderBy('position')
    //                 ->lockForUpdate()
    //                 ->limit($toSend)
    //                 ->get();

    //             if ($items->isEmpty()) {
    //                 // ✅ Ya no quedan pendientes por enviar.
    //                 // No cierres el batch: seguir esperando aceptaciones hasta expires_at
    //                 // Importante: devolvemos null para que no intente enviar nada afuera.
    //                 return [null, collect()];
    //             }

    //             // reservar: pending -> sending
    //             EmailBatchItem::query()
    //                 ->whereIn('id', $items->pluck('id'))
    //                 ->update([
    //                     'status' => 'sending',
    //                     'updated_at' => now(),
    //                 ]);

    //             return [$batch, $items];
    //         });

    //         if (!$batch || $items->isEmpty()) return self::SUCCESS;

    //         // 2) enviar fuera de TX (sin locks largos)
    //         foreach ($items as $item) {

    //             $email = DB::table('users')->where('id', $item->user_id)->value('email');

    //             if (!$email) {
    //                 EmailBatchItem::whereKey($item->id)->update([
    //                     'status' => 'failed',
    //                     'last_error' => 'User sin email',
    //                     'updated_at' => now(),
    //                 ]);
    //                 continue;
    //             }

    //             try {
    //                 $gifUrl = 'https://media.giphy.com/media/3o7aD2saalBwwftBIY/giphy.gif';
    //                 $description = "Un estudiante está buscando tutor para la materia ID {$batch->subject_id}.";

    //                 // token 1 vez
    //                 if (!$item->accept_token) {
    //                     EmailBatchItem::whereKey($item->id)->update([
    //                         'accept_token' => Str::random(60),
    //                         'updated_at' => now(),
    //                     ]);
    //                     $item->accept_token = EmailBatchItem::whereKey($item->id)->value('accept_token');
    //                 }

    //                 $buttonUrl  = route('waitlist.accept', ['t' => $item->accept_token]);
    //                 $buttonText = 'Ir a lista de espera';

    //                 Mail::to($email)->send(new TutoriaInstanteNotificacionMail(
    //                     subjectId: (int)$batch->subject_id,
    //                     gifUrl: $gifUrl,
    //                     description: $description,
    //                     buttonUrl: $buttonUrl,
    //                     buttonText: $buttonText,
    //                 ));

    //                 // marcar sent + contar
    //                 DB::transaction(function () use ($batch, $item) {
    //                     EmailBatchItem::whereKey($item->id)->update([
    //                         'status' => 'sent',
    //                         'sent_at' => now(),
    //                         'last_error' => null,
    //                         'updated_at' => now(),
    //                     ]);

    //                     EmailBatch::whereKey($batch->id)->increment('sent_count');
    //                 });
    //             } catch (Throwable $e) {
    //                 EmailBatchItem::whereKey($item->id)->update([
    //                     'status' => 'failed',
    //                     'last_error' => $e->getMessage(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         }

    //         return self::SUCCESS;
    //     } finally {
    //         DB::select("SELECT RELEASE_LOCK(?)", [$lockName]);
    //     }
    // }

    public function handle(): int
    {
        $batchIdOpt = (int) ($this->option('batch_id') ?? 0);

        // 0) cerrar batches expirados (global, rápido)
        EmailBatch::query()
            ->whereIn('status', ['pending', 'running'])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->update([
                'status' => 'done',
                'last_error' => 'expired',
                'updated_at' => now(),
            ]);

        // 1) Seleccionar batches a procesar
        $batchesQ = EmailBatch::query()
            ->whereIn('status', ['pending', 'running'])
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->orderBy('id');

        if ($batchIdOpt > 0) {
            $batchesQ->where('id', $batchIdOpt);
        } else {
            // evita que un tick enorme mate el server si hay muchos
            $batchesQ->limit(25);
        }

        $batches = $batchesQ->get();

        if ($batches->isEmpty()) {
            return self::SUCCESS;
        }

        foreach ($batches as $candidate) {
            $batchId = (int) $candidate->id;

            // ✅ lock POR batch (no global)
            $lockName = "classgo_batches_tick_batch_{$batchId}";
            $gotLock = (int) (DB::selectOne("SELECT GET_LOCK(?, 0) AS l", [$lockName])->l ?? 0);
            if ($gotLock !== 1) {
                continue; // otro proceso ya lo está tickeando
            }

            try {
                // 2) Reservar items del batch (TX corta)
                [$batch, $items] = DB::transaction(function () use ($batchId) {

                    $batch = EmailBatch::query()
                        ->where('id', $batchId)
                        ->whereIn('status', ['pending', 'running'])
                        ->lockForUpdate()
                        ->first();

                    if (!$batch) return [null, collect()];

                    if ($batch->expires_at && now()->greaterThanOrEqualTo($batch->expires_at)) {
                        $batch->update([
                            'status' => 'done',
                            'last_error' => 'expired',
                            'updated_at' => now(),
                        ]);
                        return [null, collect()];
                    }

                    if ($batch->status === 'pending') {
                        $batch->update([
                            'status' => 'running',
                            'updated_at' => now(),
                        ]);
                    }

                    $toSend = max(1, (int) $batch->batch_size);

                    $items = EmailBatchItem::query()
                        ->where('batch_id', $batch->id)
                        ->where('status', 'pending')
                        ->orderBy('position')
                        ->lockForUpdate()
                        ->limit($toSend)
                        ->get();

                    if ($items->isEmpty()) {
                        // ✅ no hay pendientes, solo esperar aceptaciones hasta expires_at
                        return [null, collect()];
                    }

                    EmailBatchItem::query()
                        ->whereIn('id', $items->pluck('id'))
                        ->update([
                            'status' => 'sending',
                            'updated_at' => now(),
                        ]);

                    return [$batch, $items];
                });

                if (!$batch || $items->isEmpty()) {
                    continue;
                }

                // 3) Enviar fuera de TX
                foreach ($items as $item) {

                    $email = DB::table('users')->where('id', $item->user_id)->value('email');

                    if (!$email) {
                        EmailBatchItem::whereKey($item->id)->update([
                            'status' => 'failed',
                            'last_error' => 'User sin email',
                            'updated_at' => now(),
                        ]);
                        continue;
                    }

                    try {
                        $gifUrl = 'https://media.giphy.com/media/3o7aD2saalBwwftBIY/giphy.gif';
                        $description = "Un estudiante está buscando tutor para la materia ID {$batch->subject_id}.";

                        // token 1 vez
                        if (!$item->accept_token) {
                            EmailBatchItem::whereKey($item->id)->update([
                                'accept_token' => Str::random(60),
                                'updated_at' => now(),
                            ]);
                            $item->accept_token = EmailBatchItem::whereKey($item->id)->value('accept_token');
                        }

                        $buttonUrl  = route('waitlist.accept', ['t' => $item->accept_token]);
                        $buttonText = 'Ir a lista de espera';

                        Mail::to($email)->send(new TutoriaInstanteNotificacionMail(
                            subjectId: (int)$batch->subject_id,
                            gifUrl: $gifUrl,
                            description: $description,
                            buttonUrl: $buttonUrl,
                            buttonText: $buttonText,
                        ));

                        DB::transaction(function () use ($batch, $item) {
                            EmailBatchItem::whereKey($item->id)->update([
                                'status' => 'sent',
                                'sent_at' => now(),
                                'last_error' => null,
                                'updated_at' => now(),
                            ]);

                            EmailBatch::whereKey($batch->id)->increment('sent_count');
                        });
                    } catch (Throwable $e) {
                        EmailBatchItem::whereKey($item->id)->update([
                            'status' => 'failed',
                            'last_error' => $e->getMessage(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            } finally {
                DB::select("SELECT RELEASE_LOCK(?)", [$lockName]);
            }
        }

        return self::SUCCESS;
    }
}
