<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

use App\Models\EmailBatch;
use App\Models\EmailBatchItem;

use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class SubjectPickerController extends Controller
{
    public function index()
    {
        $subjects = Cache::remember('subjects.all', 3600, function () {
            return DB::table('subjects')
                ->select('id', 'name')
                ->orderBy('name')
                ->get()
                ->toArray(); // importante: se guarda como array en cache
        });

        return response()->json([
            'ok' => true,
            'data' => $subjects,
        ]);
    }

    public function categoriasMaterias()
    {
        $data = Cache::remember('subject_groups:lvl2_with_subjects', now()->addHours(12), function () {

            $rows = DB::select("
            SELECT
              lvl2.id          AS id_categoria,
              lvl2.name        AS categoria,

              s.id             AS id_materia,
              s.name           AS materia
            FROM subject_groups AS lvl2
            JOIN subject_groups AS lvl3
              ON lvl3.id_padre = lvl2.id
              AND lvl3.deleted_at IS NULL
            LEFT JOIN subjects AS s
              ON s.subject_group_id = lvl3.id
              AND s.deleted_at IS NULL
            WHERE lvl2.id_padre IN (1000, 2000, 3000)
              AND lvl2.deleted_at IS NULL
            ORDER BY lvl2.id, lvl3.id, s.id
        ");

            return collect($rows)
                ->groupBy('id_categoria')
                ->map(function ($items) {
                    return [
                        'id_categoria' => $items->first()->id_categoria,
                        'categoria'    => $items->first()->categoria,
                        'materias'     => $items->whereNotNull('id_materia')->map(fn($r) => [
                            'id_materia' => $r->id_materia,
                            'materia'    => $r->materia,
                        ])->values(),
                    ];
                })
                ->values();
        });

        return response()->json(['data' => $data]);
    }
    private function getTutorsAvailableNow(int $subjectId): Collection
    {
        return $this->baseTutorsBySubjectQuery($subjectId, true)
            ->groupBy('us.user_id', 'u.email')
            ->select([
                'us.user_id',
                'u.email',
                DB::raw('ROUND(COALESCE(AVG(r.rating), 0), 1) as avg_rating'),
            ])
            ->orderByDesc('avg_rating')
            ->get();
    }

    public function tutorsAvailableNow(int $subject_id)
    {
        $tutors = $this->getTutorsAvailableNow($subject_id);

        return response()->json([
            'success' => true,
            'subject_id' => $subject_id,
            'data' => $tutors,
        ]);
    }




    private function getTutorsNotAvailableNow(int $subjectId): Collection
    {
        return $this->baseTutorsBySubjectQuery($subjectId, false)
            ->groupBy('us.user_id', 'u.email')
            ->select([
                'us.user_id',
                'u.email',
                DB::raw('ROUND(COALESCE(AVG(r.rating), 0), 1) as avg_rating'),
            ])
            ->orderByDesc('avg_rating')
            ->get();
    }



    public function tutorsNotAvailableNow(int $subject_id)
    {
        $tutors = $this->getTutorsNotAvailableNow($subject_id);

        return response()->json([
            'success' => true,
            'subject_id' => $subject_id,
            'data' => $tutors,
        ]);
    }
    public function start(Request $request)
    {
        $data = $request->validate([
            'subject_id' => ['required', 'integer', 'min:1'],
        ]);

        $subjectId = (int) $data['subject_id'];


        $studentId = (int) Auth::id();
// ✅ Si ya tiene tutoría activa o pendiente, NO iniciar batch (evita emails en vano)
$hasActiveBooking = DB::table('slot_bookings')
    ->where('student_id', $studentId)
    ->whereIn('status', [1, 4, 2]) // 1 Active, 4 Reserved, 2 Rescheduled (ajusta según tus estados reales)
    ->where('end_time', '>', now()) // todavía no terminó
    ->exists();

if ($hasActiveBooking) {
    return response()->json([
        'success' => false,
        'code' => 'has_active_booking',
        'message' => 'Ya tienes una tutoría activa o pendiente. Finaliza o cancela antes de iniciar otra.',
    ], 409);
}


        // ⬅️ define tu tiempo de espera real
        $timeoutMinutes = 5;

        return DB::transaction(function () use ($subjectId, $studentId, $timeoutMinutes) {

            // (Opcional pero recomendado) si el estudiante inicia otro batch,
            // marcamos el anterior como done/expired para que no siga enviando.
            EmailBatch::query()
                ->where('created_by', $studentId)
                ->whereIn('status', ['pending', 'running'])
                ->update([
                    'status' => 'done',
                    'last_error' => 'restarted',
                    'updated_at' => now(),
                ]);

            // 1) Crear batch
            $batch = EmailBatch::create([
                'subject_id' => $subjectId,
                'created_by' => $studentId,
                // 'status' => 'pending',
                'status' => 'running',
                'last_tutor_id' => 0,
                'sent_count' => 0,
                'batch_size' => 2, // 2 email por minuto
                'last_error' => null,
                'expires_at' => now()->addMinutes($timeoutMinutes),
            ]);

            session([
                'active_batch_id' => $batch->id,
                'active_subject_id' => $subjectId,
            ]);


            // 2) Cola congelada: primero disponibles, luego no disponibles
            $availableNow = $this->getTutorsAvailableNow($subjectId);     // Collection { user_id }
            $notAvailable = $this->getTutorsNotAvailableNow($subjectId);  // Collection { user_id }

            // 3) Unificar sin duplicados
            $seen = [];
            $queue = [];

            foreach ($availableNow as $t) {
                $uid = (int) $t->user_id;
                if ($uid > 0 && !isset($seen[$uid])) {
                    $seen[$uid] = true;
                    $queue[] = $uid;
                }
            }

            foreach ($notAvailable as $t) {
                $uid = (int) $t->user_id;
                if ($uid > 0 && !isset($seen[$uid])) {
                    $seen[$uid] = true;
                    $queue[] = $uid;
                }
            }

            // 4) Insert masivo items
            $items = [];
            $pos = 1;
            $now = now();

            foreach ($queue as $uid) {
                $items[] = [
                    'batch_id' => $batch->id,
                    'user_id' => $uid,
                    'position' => $pos++,
                    'status' => 'pending',
                    'sent_at' => null,
                    'last_error' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if ($items) {
                EmailBatchItem::insert($items);
            } else {
                $batch->update([
                    'status' => 'done',
                    'last_error' => 'no_candidates',
                ]);
            }
            // ✅ Primer lote INSTANTÁNEO (solo si hubo candidatos)
            if ($items) {
                DB::afterCommit(function () use ($batch) {
                    Artisan::call('batches:tick', ['--batch_id' => $batch->id]);
                });
            }

            return response()->json([
                'success' => true,
                'batch_id' => $batch->id,
                'subject_id' => $subjectId,
                'queued' => count($items),
                'expires_at' => optional($batch->expires_at)->toDateTimeString(),
            ]);
        });
    }



    public function status(EmailBatch $batch)
    {
        $this->ensureBatchOwner($batch);

        $items = DB::table('email_batch_items as ebi')
            ->join('users as u', 'u.id', '=', 'ebi.user_id')
            ->where('ebi.batch_id', $batch->id)
            ->orderBy('ebi.position')
            ->limit(200)
            ->get([
                'ebi.id',
                'ebi.position',
                'ebi.user_id',
                'u.email',
                'ebi.status',
                'ebi.sent_at',
                'ebi.last_error',
            ])
            ->map(fn($it) => [
                'id' => $it->id,
                'position' => $it->position,
                'user_id' => $it->user_id,
                'email' => $it->email,
                'status' => $it->status,
                'sent_at' => optional($it->sent_at)->toDateTimeString(),
                'last_error' => $it->last_error,
            ]);

        $queued = EmailBatchItem::query()
            ->where('batch_id', $batch->id)
            ->count();

        $timing = $this->batchTimingPayload($batch);

        return response()->json([
            'batch' => [
                'id' => $batch->id,
                'subject_id' => $batch->subject_id,
                'status' => $batch->status,
                'sent_count' => $batch->sent_count,
                'batch_size' => $batch->batch_size,
                'expires_at' => optional($batch->expires_at)->toDateTimeString(),
                'queued' => $queued,
                'last_error' => $batch->last_error,
                'expires_at_ms' => $timing['expires_at_ms'],
                'seconds_left' => $timing['seconds_left'],
                'server_now_ms' => $timing['server_now_ms'],
            ],
            'items' => $items,
        ]);
    }





    public function active()
    {
        $studentId = (int) Auth::id();
        $batchId = session('active_batch_id');

        // 1) Intentar por sesión
        if ($batchId) {
            $batch = EmailBatch::query()->find($batchId);

            if ($batch && !in_array($batch->status, ['done', 'failed'], true)) {
                if (!$batch->expires_at || now()->lt($batch->expires_at)) {
                    return response()->json([
                        'active' => true,
                        'batch_id' => $batch->id,
                        'subject_id' => $batch->subject_id,
                        'status' => $batch->status,
                        'sent_count' => $batch->sent_count,
                        'batch_size' => $batch->batch_size,
                        'expires_at' => optional($batch->expires_at)->toDateTimeString(),
                    ]);
                }
            }

            // sesión apunta a algo inválido
            session()->forget(['active_batch_id', 'active_subject_id']);
        }

        // 2) Fallback por BD (más robusto)
        $batch = EmailBatch::query()
            ->where('created_by', '=', $studentId)
            ->whereIn('status', ['pending', 'running'])
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->orderByDesc('id')
            ->first();

        if (!$batch) {
            return response()->json(['active' => false]);
        }

        // rehidratar sesión
        session([
            'active_batch_id' => $batch->id,
            'active_subject_id' => $batch->subject_id,
        ]);

        return response()->json([
            'active' => true,
            'batch_id' => $batch->id,
            'subject_id' => $batch->subject_id,
            'status' => $batch->status,
            'sent_count' => $batch->sent_count,
            'batch_size' => $batch->batch_size,
            'expires_at' => optional($batch->expires_at)->toDateTimeString(),
        ]);
    }

    public function acceptWaitlist(Request $request)
    {
        $token = (string) $request->query('t');
        if ($token === '') abort(404);

        // 1) Buscar item por token
        $item = EmailBatchItem::where('accept_token', $token)->first();
        if (!$item) abort(404);

        // 2) Buscar batch y validar expiración
        $batch = EmailBatch::find($item->batch_id);
        if (!$batch) abort(404);

        if ($batch->expires_at && now()->greaterThanOrEqualTo($batch->expires_at)) {
            return view('vistas.view.pages.waitlistTutor', [
                'status' => 'expired',
            ]);
        }

        // 3) Marcar accepted (idempotente)
        if (!$item->accepted_at) {
            $item->accepted_at = now();
            $item->status = 'accepted';
            $item->save();
        }



        $expiresAt = $batch->expires_at;

        $secondsLeft = $expiresAt ? now()->diffInSeconds($expiresAt, false) : null;

        // ✅ timestamp absoluto (servidor) en milisegundos
        $expiresAtMs = $expiresAt ? ($expiresAt->getTimestamp() * 1000) : null;

        return view('vistas.view.pages.waitlistTutor', [
            'status' => ($secondsLeft !== null && $secondsLeft <= 0) ? 'expired' : 'ok',
            'batch_id' => $batch->id,
            'subject_id' => $batch->subject_id,
            'expires_at' => optional($expiresAt)->toDateTimeString(),
            'seconds_left' => $secondsLeft,
            'expires_at_ms' => $expiresAtMs,   // ✅ NUEVO
        ]);
    }


    public function acceptedTutors(Request $request, EmailBatch $batch)
    {
        $this->ensureBatchOwner($batch);

        $afterAt = $request->query('after_accepted_at');
        $afterId = (int) $request->query('after_id', 0);
        $limit   = max(1, min((int)$request->query('limit', 20), 50));

        $ratingsSub = $this->ratingsSubquery();

        $q = DB::table('email_batch_items as ebi')
            ->join('users as u', 'u.id', '=', 'ebi.user_id')
            ->leftJoin('profiles as p', 'p.user_id', '=', 'ebi.user_id')
            ->leftJoinSub($ratingsSub, 'rt', function ($join) {
                $join->on('rt.user_id', '=', 'ebi.user_id');
            })
            ->where('ebi.batch_id', $batch->id)
            ->whereNotNull('ebi.accepted_at');

        $this->applyAcceptedCursor($q, $afterAt, $afterId);

        $rows = $q->orderBy('ebi.accepted_at')
            ->orderBy('ebi.id')
            ->limit($limit)
            ->get([
                'ebi.id',
                'ebi.user_id',
                'ebi.accepted_at',
                'u.email',
                'p.first_name',
                'p.last_name',
                'p.image',
                'p.price',
                'p.verified_at',
                DB::raw("CASE WHEN p.verified_at IS NULL THEN 0 ELSE 1 END as is_verified"),
                DB::raw('COALESCE(rt.rating, 0.0) as rating'),
            ]);

        $last = $rows->last();

        return response()->json([
            'batch_id' => $batch->id,
            'count' => $rows->count(),
            'data' => $rows,
            'next_after_accepted_at' => $last?->accepted_at,
            'next_after_id' => $last?->id ?? $afterId,
        ]);
    }




    public function chooseTutor(Request $request, EmailBatch $batch)
    {
        // seguridad: solo el dueño elige
        if ((int) $batch->created_by !== (int) Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'item_id' => ['required', 'integer', 'min:1'],
        ]);

        $itemId = (int) $data['item_id'];

        return DB::transaction(function () use ($batch, $itemId) {

            // Lock del batch para evitar doble elección simultánea
            $batch = EmailBatch::query()
                ->whereKey($batch->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Si está expirado, no se puede elegir
            if ($batch->expires_at && now()->greaterThanOrEqualTo($batch->expires_at)) {
                $batch->update([
                    'status' => 'done',
                    'last_error' => 'expired',
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Batch expirado',
                ], 409);
            }

            // Si ya hay uno elegido, responde idempotente
            $alreadyChosen = EmailBatchItem::query()
                ->where('batch_id', $batch->id)
                ->where('status', 'chosen')
                ->first();

            if ($alreadyChosen) {
                $u = DB::table('users')
                    ->select('id', 'name', 'email')
                    ->where('id', $alreadyChosen->user_id)
                    ->first();

                return response()->json([
                    'success' => true,
                    'batch_id' => $batch->id,
                    'chosen' => [
                        'item_id' => $alreadyChosen->id,
                        'user_id' => $alreadyChosen->user_id,
                        'user' => $u,
                        'chosen_at' => optional($alreadyChosen->chosen_at)->toDateTimeString(),
                    ],
                    // AJUSTA ESTA RUTA A TU PROYECTO (o devuelve null si aún no existe)
                    'redirect_to' => null,
                    // route('student.payments.show', ['batch' => $batch->id]),
                ]);
            }

            // Lock del item a elegir
            $item = EmailBatchItem::query()
                ->where('batch_id', $batch->id)
                ->whereKey($itemId)
                ->lockForUpdate()
                ->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item no pertenece al batch',
                ], 404);
            }

            // Solo se puede elegir entre aceptados
            if ($item->status !== 'accepted') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo puedes elegir un tutor que haya aceptado',
                    'current_status' => $item->status,
                ], 409);
            }

            // Marcar elegido
            $item->status = 'chosen';
            $item->chosen_at = now();
            $item->save();

            // Expirar a todos los demás (pendientes/enviados/aceptados)
            EmailBatchItem::query()
                ->where('batch_id', $batch->id)
                ->where('id', '!=', $item->id)
                ->whereIn('status', ['pending', 'sending', 'sent', 'accepted'])
                ->update([
                    'status' => 'expired',
                    'last_error' => 'not_chosen',
                    'updated_at' => now(),
                ]);

            // Marcar batch como matched (y guardar elegido en batch)
            $batch->update([
                'status' => 'matched',
                'accepted_user_id' => $item->user_id,
                'accepted_item_id' => $item->id,
                'accepted_at' => now(),
            ]);

            $u = DB::table('users')
                ->select('id', 'name', 'email')
                ->where('id', $item->user_id)
                ->first();

            return response()->json([
                'success' => true,
                'batch_id' => $batch->id,
                'chosen' => [
                    'item_id' => $item->id,
                    'user_id' => $item->user_id,
                    'user' => $u,
                    'chosen_at' => optional($item->chosen_at)->toDateTimeString(),
                ],
                // AJUSTA ESTA RUTA
                'redirect_to' => null,
                // route('student.payments.show', ['batch' => $batch->id]),
            ]);
        });
    }


    ///////////////////////  nuevo ///////////////////////
    // ✅ Seguridad reusable
    private function ensureBatchOwner(EmailBatch $batch): void
    {
        if ((int)$batch->created_by !== (int) Auth::id()) {
            abort(403, 'Forbidden');
        }
    }

    // ✅ Payload de tiempos reusable
    private function batchTimingPayload(EmailBatch $batch): array
    {
        $expiresAt = $batch->expires_at;

        return [
            'expires_at_ms' => $expiresAt ? $expiresAt->getTimestamp() * 1000 : null,
            'seconds_left'  => $expiresAt ? now()->diffInSeconds($expiresAt, false) : null,
            'server_now_ms' => now()->getTimestamp() * 1000,
        ];
    }

    // ✅ Subquery rating promedio por user_id (mismo cálculo pero más eficiente en joins)
    private function ratingsSubquery()
    {
        return DB::table('user_reviews as ur')
            ->join('reviews as r', function ($join) {
                $join->on('r.id', '=', 'ur.review_id')
                    ->where('r.status', '=', 'active');
            })
            ->groupBy('ur.user_id')
            ->select([
                'ur.user_id',
                DB::raw('ROUND(AVG(r.rating), 1) as rating'),
            ]);
    }

    // ✅ Base query para tutores por materia (solo cambia available vs notAvailable)
    private function baseTutorsBySubjectQuery(int $subjectId, bool $mustBeAvailableNow)
    {
        $q = DB::table('user_subject as us')
            ->join('users as u', 'u.id', '=', 'us.user_id')
            ->leftJoin('user_reviews as ur', 'ur.user_id', '=', 'us.user_id')
            ->leftJoin('reviews as r', function ($join) {
                $join->on('r.id', '=', 'ur.review_id');
                // si quieres activar solo reviews activas aquí, habilita:
                // $join->where('r.status', '=', 'active');
            })
            ->where('us.subject_id', $subjectId)
            ->whereNotNull('u.email');

        $slotSub = DB::table('user_subject_slots as s')
            ->select(DB::raw(1))
            ->whereColumn('s.user_id', 'us.user_id')
            ->whereRaw('s.date = CURDATE()')
            ->whereRaw('s.start_time <= CURTIME()')
            ->whereRaw('s.end_time > CURTIME()');

        if ($mustBeAvailableNow) {
            $q->whereExists($slotSub);
        } else {
            $q->whereNotExists($slotSub);
        }

        return $q;
    }

    // ✅ Cursor reusable para acceptedTutors
    private function applyAcceptedCursor($q, ?string $afterAt, int $afterId): void
    {
        if (!$afterAt) return;

        $q->where(function ($w) use ($afterAt, $afterId) {
            $w->where('ebi.accepted_at', '>', $afterAt)
                ->orWhere(function ($w2) use ($afterAt, $afterId) {
                    $w2->where('ebi.accepted_at', '=', $afterAt)
                        ->where('ebi.id', '>', $afterId);
                });
        });
    }

    // Este es el endpoint que vas a poner en el botón de la card (“Solicitar”).
    public function reserveTutor(Request $request, EmailBatch $batch)
    {
        if ((int)$batch->created_by !== (int)Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'item_id' => ['required', 'integer', 'min:1'],
        ]);

        $itemId = (int)$data['item_id'];

        return DB::transaction(function () use ($batch, $itemId) {

            $batchRow = DB::table('email_batches')
                ->where('id', (int)$batch->id)
                ->lockForUpdate()
                ->first();

            if (!$batchRow) return response()->json(['message' => 'Batch not found'], 404);

            if ($batchRow->expires_at && now()->greaterThanOrEqualTo($batchRow->expires_at)) {
                return response()->json(['message' => 'Batch expirado'], 409);
            }

            // ✅ Si ya hay booking creado para este batch, idempotente
            if (!empty($batchRow->booking_id)) {
                $existing = DB::table('slot_bookings')->where('id', (int)$batchRow->booking_id)->first();
                return response()->json([
                    'success' => true,
                    'message' => 'Booking ya reservado para este batch.',
                    'booking' => $existing,
                ]);
            }

            $item = DB::table('email_batch_items')
                ->where('batch_id', (int)$batchRow->id)
                ->where('id', $itemId)
                ->lockForUpdate()
                ->first();

            if (!$item) return response()->json(['message' => 'Item no pertenece al batch'], 404);

            if ((string)$item->status !== 'accepted') {
                return response()->json(['message' => 'Solo se puede reservar un tutor aceptado'], 409);
            }

            $studentId = (int)$batchRow->created_by;
            $tutorId   = (int)$item->user_id;

            $start = now()->addMinutes(5)->startOfMinute();
            $end   = (clone $start)->addMinutes(20);

            // 🔒 Anti-solapamiento
            $conflict = DB::table('slot_bookings')
                ->where('tutor_id', $tutorId)
                ->whereIn('status', [1, 2, 4]) // Active/Rescheduled/Reserved
                ->where('start_time', '<', $end)
                ->where('end_time', '>', $start)
                ->lockForUpdate()
                ->exists();

            if ($conflict) {
                return response()->json(['message' => 'Tutor ya reservado por otro estudiante. Elige otro.'], 409);
            }

            $fee = (float)DB::table('profiles')->where('user_id', $tutorId)->value('price');
            if ($fee < 0) $fee = 0;

            $bookingId = DB::table('slot_bookings')->insertGetId([
                'student_id' => $studentId,
                'tutor_id'   => $tutorId,
                'subject_id' => (int)$batchRow->subject_id,
                'user_subject_slot_id' => null,
                'start_time' => $start->toDateTimeString(),
                'end_time'   => $end->toDateTimeString(),
                'session_fee' => $fee,
                'booked_at'  => now()->toDateTimeString(),
                'meeting_link' => null,
                'status'     => 4, // Reserved / Pendiente de pago
                'meta_data'  => json_encode([
                    'source' => 'email_batch',
                    'batch_id' => (int)$batchRow->id,
                    'item_id'  => (int)$item->id,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ✅ OJO: email_batch_items enum NO tiene "reserved" => usamos chosen
            DB::table('email_batch_items')->where('id', (int)$item->id)->update([
                'status' => 'chosen',
                'chosen_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('email_batch_items')
                ->where('batch_id', (int)$batchRow->id)
                ->where('id', '!=', (int)$item->id)
                ->whereIn('status', ['pending', 'sending', 'sent', 'accepted'])
                ->update([
                    'status' => 'expired',
                    'last_error' => 'not_chosen',
                    'updated_at' => now(),
                ]);

            // ✅ Ahora sí: guardar booking_id en batch
            DB::table('email_batches')->where('id', (int)$batchRow->id)->update([
                'status' => 'matched',
                'accepted_user_id' => $tutorId,
                'accepted_item_id' => (int)$item->id,
                'accepted_at' => now(),
                'booking_id' => $bookingId,
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'booking_id' => $bookingId,
                'booking_status' => 4,
                'start_time' => $start->toDateTimeString(),
                'end_time' => $end->toDateTimeString(),
                'session_fee' => $fee,
            ]);
        });
    }






    // guarda el archivo en public/storage/qr/

    // guarda/actualiza payment_slot_bookings.image_url

    // NO cambia slot_bookings.status (se queda en 4 reserved)

    // envía email al tutor con datos tipo factura (sin adjuntar comprobante)

    // devuelve public_url para que el frontend pueda mostrar preview si quiere
    public function uploadReceipt(Request $request, int $bookingId)
    {
        $studentId = (int) Auth::id();



        // misma validación que en storeBooking (misma forma)
        $request->validate([
            // 'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        DB::beginTransaction();

        try {
            // 1) Lock booking + validar dueño
            $booking = DB::table('slot_bookings')
                ->where('id', $bookingId)
                ->where('student_id', $studentId)
                ->lockForUpdate()
                ->first();

            if (!$booking) {
                DB::rollBack();
                return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
            }

            // 2) Solo si está reservado (4)
            if ((int) $booking->status !== 4) {
                DB::rollBack();
                return response()->json([
                    'ok' => false,
                    'message' => 'Este booking no admite comprobante (estado inválido).'
                ], 409);
            }

            // 3) Guardar archivo EXACTAMENTE como tu storeBooking (public/storage/qr + move)
            $file = $request->file('comprobante');
            if (!$file) {
                DB::rollBack();
                return response()->json(['ok' => false, 'message' => 'Falta comprobante'], 422);
            }

            $original = preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $filename = uniqid() . '_' . $original;

            $dest = public_path('storage/qr');
            if (!file_exists($dest))
                mkdir($dest, 0775, true);

            $file->move($dest, $filename);
            $imageUrl = 'qr/' . $filename;
            $publicUrl = asset('storage/' . $imageUrl);

            // 4) Upsert comprobante (1 por booking)
            DB::table('payment_slot_bookings')->updateOrInsert(
                ['slot_booking_id' => $bookingId],
                [
                    'image_url'  => $imageUrl,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // (opcional, pero consistente con storeBooking: también guardar en slot_payments.receipt_pdf si existe el registro)
            // DB::table('slot_payments')
            //     ->where('slot_booking_id', $bookingId)
            //     ->update([
            //         'receipt_pdf' => $imageUrl,
            //         'updated_at'  => now(),
            //     ]);

            DB::table('slot_payments')->updateOrInsert(
                ['slot_booking_id' => $bookingId],
                [
                    'payment_date'   => now()->toDateString(),
                    'payment_method' => 'transfer',
                    'amount'         => (float) ($booking->session_fee ?? 0),
                    'status'         => 1, // Pendiente
                    'message'        => 'Pago pendiente de verificación',
                    'receipt_pdf'    => $imageUrl,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );

            // 5) Datos "tipo factura" para el tutor
            $tutor = DB::table('users as u')
                ->leftJoin('profiles as p', 'p.user_id', '=', 'u.id')
                ->where('u.id', (int) $booking->tutor_id)
                ->first(['u.email', 'p.first_name', 'p.last_name']);

            if (!$tutor || empty($tutor->email)) {
                DB::rollBack();
                return response()->json([
                    'ok' => false,
                    'message' => 'Tutor sin email, no se puede notificar.'
                ], 422);
            }

            $student = DB::table('users as u')
                ->leftJoin('profiles as p', 'p.user_id', '=', 'u.id')
                ->where('u.id', (int) $booking->student_id)
                ->first(['u.email', 'p.first_name', 'p.last_name', 'p.phone_number']);

            $subjectName = DB::table('subjects')
                ->where('id', (int) $booking->subject_id)
                ->value('name');

            $tutorName    = trim(($tutor->first_name ?? '') . ' ' . ($tutor->last_name ?? ''));
            $studentName  = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
            $studentPhone = $student->phone_number ?? '-';

            $amount = number_format((float) ($booking->session_fee ?? 0), 2, '.', '');
            $start  = (string) ($booking->start_time ?? '-');
            $end    = (string) ($booking->end_time ?? '-');

            // 6) Email al tutor SIN adjunto (solo datos)
            Mail::send([], [], function ($message) use (
                $tutor,
                $bookingId,
                $tutorName,
                $studentName,
                $studentPhone,
                $subjectName,
                $amount,
                $start,
                $end
            ) {
                $message->to($tutor->email)
                    ->subject("Pago reportado - Tutoría #{$bookingId}")
                    ->setBody(
                        "<h3>Pago reportado (pendiente de tu aprobación)</h3>
                    <p><b>Booking:</b> #{$bookingId}</p>
                    <p><b>Estudiante:</b> " . e($studentName ?: '-') . "</p>
                    <p><b>Teléfono:</b> " . e($studentPhone) . "</p>
                    <p><b>Materia:</b> " . e($subjectName ?: '-') . "</p>
                    <p><b>Horario:</b> " . e($start) . " - " . e($end) . "</p>
                    <p><b>Monto:</b> {$amount} Bs</p>
                    <p><b>Acción:</b> Ingresa a la plataforma para ver el comprobante y presiona <b>“Aceptar tutoría”</b> o <b>“Rechazar”</b>.</p>",
                        'text/html'
                    );
            });

            DB::commit();

            // 7) Respuesta para frontend (misma vista)
            return response()->json([
                'ok' => true,
                'booking_id' => $bookingId,
                'booking_status' => 4, // reserved
                'image_url' => $imageUrl,
                'public_url' => '/storage/' . $imageUrl,
                'message' => 'Comprobante subido. Espera aprobación del tutor.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'ok' => false,
                'message' => 'Validación fallida',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            // Log::error('uploadReceipt error: ' . $e->getMessage());

            return response()->json([
                'ok' => false,
                'message' => 'Error al subir comprobante',
                'debug' => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }



    // Si ui_state == "waiting" → “En espera”

    // Si ui_state == "batch_expired_waiting" → “Batch expiró”

    // Si ui_state == "payment_phase" → Mostrar comprobante si existe + botones Aceptar/Rechazar

    // Si ui_state == "accepted" → mostrar botón Meet

    // Si ui_state == "rejected" → mostrar “Rechazado” y desactivar todo

    // Nota: aunque batch.expired == true, si ui_state es payment_phase/accepted, sigues normal.

    public function tutorWaitlistStatus(Request $request)
    {
        $token = (string) $request->query('t');
        if ($token === '') {
            return response()->json(['ok' => false, 'message' => 'Missing token'], 400);
        }

        // 1) item por token (define qué tutor es)
        $item = DB::table('email_batch_items')
            ->where('accept_token', $token)
            ->first();

        if (!$item) {
            return response()->json(['ok' => false, 'message' => 'Invalid token'], 404);
        }

        // 2) batch
        $batch = DB::table('email_batches')
            ->where('id', (int)$item->batch_id)
            ->first();

        if (!$batch) {
            return response()->json(['ok' => false, 'message' => 'Batch not found'], 404);
        }

        $batchExpired = !empty($batch->expires_at) && now()->greaterThanOrEqualTo($batch->expires_at);

        // 3) ¿Este tutor fue elegido?
        $isChosen = ((string)$batch->status === 'matched' && (int)$batch->accepted_item_id === (int)$item->id);

        // 4) bookingId (si ya estamos en fase de pago/meet)
        $bookingId = (int)($batch->booking_id ?? 0);

        // Caso A: NO elegido y batch expiró = fin de espera
        if (!$isChosen && $batchExpired) {
            return response()->json([
                'ok' => true,
                'ui_state' => 'batch_expired_waiting',
                'batch' => [
                    'id' => (int)$batch->id,
                    'status' => (string)$batch->status,
                    'expires_at' => $batch->expires_at,
                    'expired' => true,
                ],
                'chosen' => [
                    'is_chosen' => false,
                    'booking_id' => null,
                ],
                'message' => 'El batch expiró y no fuiste elegido.',
            ]);
        }

        // Caso B: NO elegido (todavía) y NO expiró = waiting
        if (!$isChosen) {
            return response()->json([
                'ok' => true,
                'ui_state' => 'waiting',
                'batch' => [
                    'id' => (int)$batch->id,
                    'status' => (string)$batch->status,
                    'expires_at' => $batch->expires_at,
                    'expired' => $batchExpired,
                ],
                'chosen' => [
                    'is_chosen' => false,
                    'booking_id' => null,
                ],
                'message' => 'Aún no fuiste elegido.',
            ]);
        }

        // Caso C: Fue elegido pero aún NO hay booking_id
        if ($bookingId <= 0) {
            return response()->json([
                'ok' => true,
                'ui_state' => 'payment_phase',
                'batch' => [
                    'id' => (int)$batch->id,
                    'status' => (string)$batch->status,
                    'expires_at' => $batch->expires_at,
                    'expired' => $batchExpired,
                ],
                'chosen' => [
                    'is_chosen' => true,
                    'booking_id' => null,
                ],
                'message' => 'Fuiste elegido. Esperando creación del booking...',
            ]);
        }

        // 5) cargar booking
        $booking = DB::table('slot_bookings')->where('id', $bookingId)->first();
        if (!$booking) {
            return response()->json(['ok' => false, 'message' => 'Booking not found'], 404);
        }

        // seguridad extra: booking debe pertenecer a este tutor
        if ((int)$booking->tutor_id !== (int)$item->user_id) {
            return response()->json(['ok' => false, 'message' => 'Token mismatch'], 403);
        }

        // 6) comprobante
        $receipt = DB::table('payment_slot_bookings')
            ->where('slot_booking_id', $bookingId)
            ->first();

        $hasReceipt = (bool)$receipt;
        $receiptUrl = $receipt?->image_url ? ('/storage/' . ltrim($receipt->image_url, '/')) : null;

        // 7) datos estudiante (para mostrar)
        $student = DB::table('users as u')
            ->leftJoin('profiles as p', 'p.user_id', '=', 'u.id')
            ->where('u.id', (int)$booking->student_id)
            ->first(['u.email', 'p.first_name', 'p.last_name', 'p.phone_number']);


        $studentName = $student ? trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')) : null;

        // 8) estado booking
        $status = (int)($booking->status ?? 0);

        // UI State según booking
        $uiState = 'payment_phase';   // reserved(4)
        if ($status === 1) $uiState = 'accepted';
        if ($status === 0) $uiState = 'rejected';

        // Acciones
        $canAccept = ($status === 4) && $hasReceipt;
        $canReject = ($status === 4);
        $canJoinMeet = ($status === 1) && !empty($booking->meeting_link);

        return response()->json([
            'ok' => true,
            'ui_state' => $uiState,
            'batch' => [
                'id' => (int)$batch->id,
                'status' => (string)$batch->status,
                'expires_at' => $batch->expires_at,
                'expired' => $batchExpired,
            ],
            'chosen' => [
                'is_chosen' => true,
                'booking_id' => $bookingId,
            ],
            'booking' => [
                'id' => (int)$booking->id,
                'status' => $status,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
                'session_fee' => $booking->session_fee,
                'meeting_link' => $booking->meeting_link,
            ],
            'payment' => [
                'has_receipt' => $hasReceipt,
                'receipt_url' => $receiptUrl,
            ],
            'student' => [
                'name' => $studentName,
                'email' => $student->email ?? null,
                'phone' => $student->phone_number ?? null,
            ],
            'actions' => [
                'can_accept' => $canAccept,
                'can_reject' => $canReject,
                'can_join_meet' => $canJoinMeet,
            ],
        ]);
    }


    // Valida token

    // Verifica que ese tutor fue el elegido en el batch

    // Verifica que existe booking_id en el batch

    // Verifica que booking está en reserved(4)

    // Verifica que existe comprobante en payment_slot_bookings

    // Cambia booking a active(1)

    // Si meeting_link está vacío, le pone un link genérico (por ahora)

    public function tutorAcceptBooking(Request $request)
    {
        $token = (string) $request->query('t');
        if ($token === '') return response()->json(['ok' => false, 'message' => 'Missing token'], 400);

        return DB::transaction(function () use ($token) {

            $item = DB::table('email_batch_items')
                ->where('accept_token', $token)
                ->lockForUpdate()
                ->first();

            if (!$item) return response()->json(['ok' => false, 'message' => 'Invalid token'], 404);

            $batch = DB::table('email_batches')
                ->where('id', (int)$item->batch_id)
                ->lockForUpdate()
                ->first();

            if (!$batch) return response()->json(['ok' => false, 'message' => 'Batch not found'], 404);

            $isChosen = ((string)$batch->status === 'matched' && (int)$batch->accepted_item_id === (int)$item->id);
            if (!$isChosen) return response()->json(['ok' => false, 'message' => 'Not chosen'], 409);

            $bookingId = (int)($batch->booking_id ?? 0);
            if ($bookingId <= 0) return response()->json(['ok' => false, 'message' => 'Booking not created yet'], 409);

            $booking = DB::table('slot_bookings')
                ->where('id', $bookingId)
                ->lockForUpdate()
                ->first();

            if (!$booking) return response()->json(['ok' => false, 'message' => 'Booking not found'], 404);

            if ((int)$booking->tutor_id !== (int)$item->user_id) {
                return response()->json(['ok' => false, 'message' => 'Token mismatch'], 403);
            }

            if ((int)$booking->status !== 4) {
                return response()->json(['ok' => false, 'message' => 'Booking status invalid for accept'], 409);
            }

            $receipt = DB::table('payment_slot_bookings')->where('slot_booking_id', $bookingId)->first();
            if (!$receipt || empty($receipt->image_url)) {
                return response()->json(['ok' => false, 'message' => 'No receipt uploaded'], 409);
            }

            $meetingLink = $booking->meeting_link ?: (env('MEET_GENERIC_LINK') ?: 'https://meet.google.com/upy-mxim-nrm');

            DB::table('slot_bookings')->where('id', $bookingId)->update([
                'status' => 1, // aceptado / active
                'meeting_link' => $meetingLink,
                // 'updated_at' => now(),
            ]);
            DB::table('slot_payments')
                ->where('slot_booking_id', $bookingId)
                ->update([
                    'status' => 2, // Pagado
                    'message' => 'Pago verificado por el tutor',
                    'updated_at' => now(),
                ]);


            // 3) cerrar batch (importante para que siguientes batchs funcionen)
            DB::table('email_batches')
                ->where('id', (int)$batch->id)
                ->update([
                    'status' => 'done',
                    // 'last_error' => null,
                    'updated_at' => now(),
                ]);




            //////////////// despues reemplazar por link real de vista/email ////////////////
// Datos estudiante
$student = DB::table('users as u')
    ->leftJoin('profiles as p', 'p.user_id', '=', 'u.id')
    ->where('u.id', (int)$booking->student_id)
    ->first(['u.email', 'p.first_name', 'p.last_name']);

$studentEmail = $student->email ?? null;

if ($studentEmail) {
    $studentName = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
    $subjectName = DB::table('subjects')->where('id', (int)$booking->subject_id)->value('name');

    Mail::send([], [], function ($message) use ($studentEmail, $studentName, $bookingId, $meetingLink, $subjectName, $booking) {
        $message->to($studentEmail)
            ->subject("Tutoría aceptada #{$bookingId}")
            ->setBody(
                "<h3>✅ Tu tutoría fue aceptada</h3>
                 <p><b>Booking:</b> #{$bookingId}</p>
                 <p><b>Estudiante:</b> " . e($studentName ?: '-') . "</p>
                 <p><b>Materia:</b> " . e($subjectName ?: '-') . "</p>
                 <p><b>Horario:</b> " . e($booking->start_time) . " - " . e($booking->end_time) . "</p>
                 <p><b>Meet:</b> <a href='{$meetingLink}'>" . e($meetingLink) . "</a></p>",
                'text/html'
            );
    });
}
            ////////////////////////////////////////////////////////////////////////////////


            // ✅ NO tocamos email_batch_items a "approved" (no existe)
            return response()->json([
                'ok' => true,
                'ui_state' => 'accepted',
                'booking_id' => $bookingId,
                'booking_status' => 1,
                'meeting_link' => $meetingLink,
            ]);
        });
    }


    // Valida token

    // Verifica que fue elegido

    // Verifica booking reservado(4)

    // Cambia booking a cancelado

    // Limpia meeting_link en BD (para que la plataforma no lo muestre)

    // Libera el batch (para que el estudiante pueda elegir otro tutor) sin crear nuevo batch (si quieres)



    public function tutorRejectBooking(Request $request)
    {
        $token = (string) $request->query('t');
        if ($token === '') return response()->json(['ok' => false, 'message' => 'Missing token'], 400);

        $data = $request->validate([
            'reason' => ['nullable', 'string', 'max:255'],
        ]);
        $reason = $data['reason'] ?? 'Rechazado por el tutor';

        return DB::transaction(function () use ($token, $reason) {

            $item = DB::table('email_batch_items')
                ->where('accept_token', $token)
                ->lockForUpdate()
                ->first();

            if (!$item) return response()->json(['ok' => false, 'message' => 'Invalid token'], 404);

            $batch = DB::table('email_batches')
                ->where('id', (int)$item->batch_id)
                ->lockForUpdate()
                ->first();

            if (!$batch) return response()->json(['ok' => false, 'message' => 'Batch not found'], 404);

            $isChosen = ((string)$batch->status === 'matched' && (int)$batch->accepted_item_id === (int)$item->id);
            if (!$isChosen) return response()->json(['ok' => false, 'message' => 'Not chosen'], 409);

            $bookingId = (int)($batch->booking_id ?? 0);
            if ($bookingId <= 0) return response()->json(['ok' => false, 'message' => 'Booking not created yet'], 409);

            $booking = DB::table('slot_bookings')
                ->where('id', $bookingId)
                ->lockForUpdate()
                ->first();

            if (!$booking) return response()->json(['ok' => false, 'message' => 'Booking not found'], 404);

            if ((int)$booking->tutor_id !== (int)$item->user_id) {
                return response()->json(['ok' => false, 'message' => 'Token mismatch'], 403);
            }

            if ((int)$booking->status !== 4) {
                return response()->json(['ok' => false, 'message' => 'Booking status invalid for reject'], 409);
            }

            // Puedes usar 0 (cancelado) como venías usando, o 3 (refunded). Yo dejo 0 como "cancelado".
            $meta = (array) json_decode($booking->meta_data ?? '{}', true);
            $meta['rejected_reason'] = $reason;
            $meta['rejected_at'] = now()->toDateTimeString();

            DB::table('slot_bookings')->where('id', $bookingId)->update([
                'status' => 3, // no completado / cancelado
                'meeting_link' => null,
                'meta_data' => json_encode($meta),
                // 'updated_at' => now(),
            ]);

            // ✅ No usamos status='rejected' (no existe). Solo anotamos error.
            DB::table('email_batch_items')->where('id', (int)$item->id)->update([
                'last_error' => $reason,
                'updated_at' => now(),
            ]);

            // ✅ Liberar batch para que estudiante elija otro (ahora sí existe booking_id)
            DB::table('email_batches')->where('id', (int)$batch->id)->update([
                'status' => 'done',
                'booking_id' => null,
                'accepted_user_id' => null,
                'accepted_item_id' => null,
                'accepted_at' => null,
                'last_error' => 'rejected_by_tutor',
                'updated_at' => now(),
            ]);

            return response()->json([
                'ok' => true,
                'ui_state' => 'rejected',
                'booking_id' => $bookingId,
                'booking_status' => 0,
                'reason' => $reason,
            ]);
        });
    }


    //     Método: studentUploadReceipt(Request $request, $booking)

    // Valida que el booking sea del estudiante

    // Solo permite si slot_bookings.status == 4 (reserved) (o el que uses como “en pago”)

    // Guarda imagen en public/storage/qr/... (o public/storage/receipts/...)

    // Inserta/actualiza payment_slot_bookings con image_url

    // Crea link genérico si quieres cumplir tu regla “al pagar ya existe link” (para pruebas)
    public function studentUploadReceipt(Request $request, $booking)
    {
        $request->validate([
            // 'comprobante' => ['required', 'file', 'max:20480', 'mimes:image/jpeg,image/png,application/pdf'], 
            'comprobante' => ['required', 'file', 'max:20480', 'mimes:jpg,jpeg,png,pdf'], // 20MB
        ]);

        $studentId = (int) Auth::id();
        $bookingId = (int) $booking;

        return DB::transaction(function () use ($request, $studentId, $bookingId) {

            $b = DB::table('slot_bookings')
                ->where('id', $bookingId)
                ->lockForUpdate()
                ->first();

            if (!$b) {
                return response()->json(['ok' => false, 'message' => 'Booking no encontrado'], 404);
            }

            if ((int)$b->student_id !== $studentId) {
                return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
            }

            if ((int)$b->status !== 4) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Estado inválido para subir comprobante',
                    'booking_status' => (int)$b->status,
                ], 409);
            }

            // ✅ Guardar en storage/app/public/qr
            // ✅ Guardar directo en public/storage/qr (SIN symlink)
            $file = $request->file('comprobante');

            $original = preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $safeOriginal = preg_replace('/[^A-Za-z0-9_\.\-]/', '', $original);
            $filename = uniqid() . '_' . $safeOriginal;

            $dest = public_path('storage/qr');
            if (!is_dir($dest)) {
                mkdir($dest, 0775, true);
            }

            $file->move($dest, $filename);

            // En DB guarda relativo: "qr/xxx.ext"
            $imageUrl = 'qr/' . $filename;

            DB::table('payment_slot_bookings')->updateOrInsert(
                ['slot_booking_id' => $bookingId],
                [
                    'image_url' => $imageUrl,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            // meet link genérico (opcional)
            $genericMeet = 'https://meet.google.com/upy-mxim-nrm';
            if (empty($b->meeting_link)) {
                DB::table('slot_bookings')
                    ->where('id', $bookingId)
                    ->update([
                        'meeting_link' => $genericMeet,
                        'updated_at' => now(),
                    ]);
            } else {
                $genericMeet = $b->meeting_link;
            }

            return response()->json([
                'ok' => true,
                'booking_id' => $bookingId,
                'message' => 'Comprobante subido. Esperando aprobación del tutor.',
                'receipt_url' => '/storage/' . ltrim($imageUrl, '/'),
                'meeting_link' => $genericMeet,
            ]);
        });
    }

    //     Método: studentBookingStatus(Request $request, $booking)

    // Para que tu JS:

    // si status == 1 → habilite botón “Ir a Meet”

    // si status == 0 → muestre “Rechazado” y vuelva a seleccionar tutor

    // si status == 4 → muestre “En revisión”

    public function studentBookingStatus(Request $request, $booking)
    {
        $studentId = (int) Auth::id();
        $bookingId = (int) $booking;

        $b = DB::table('slot_bookings')
            ->where('id', $bookingId)
            ->first();

        if (!$b) {
            return response()->json(['ok' => false, 'message' => 'Booking no encontrado'], 404);
        }

        if ((int)$b->student_id !== $studentId) {
            return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
        }

        $receipt = DB::table('payment_slot_bookings')
            ->where('slot_booking_id', $bookingId)
            ->first();

        $hasReceipt = (bool) $receipt;
        $receiptUrl = $receipt?->image_url ? ('/storage/' . ltrim($receipt->image_url, '/')) : null;

        // UI state para tu vista
        $ui = 'payment_phase'; // reserved(4)
        if ((int)$b->status === 1) $ui = 'accepted';
        if ((int)$b->status === 0) $ui = 'rejected';

        return response()->json([
            'ok' => true,
            'ui_state' => $ui,
            'booking' => [
                'id' => (int)$b->id,
                'status' => (int)$b->status,
                'start_time' => $b->start_time,
                'end_time' => $b->end_time,
                'session_fee' => $b->session_fee,
                'meeting_link' => $b->meeting_link, // tu UI decide cuándo mostrarlo
            ],
            'payment' => [
                'has_receipt' => $hasReceipt,
                'receipt_url' => $receiptUrl,
            ],
        ]);
    }

    //     verifica dueño del batch

    // lock batch + lock item

    // valida que item esté accepted

    // valida que en ese batch no exista booking ya creado

    // calcula horario automático: start = now()+5min, end = start+20min

    // valida solapamiento en slot_bookings del tutor con status [4,reserved] o [1,active]

    // inserta slot_bookings con status=4 reserved

    // marca batch matched y guarda booking_id, accepted_item_id, etc

    // expira el resto de items del batch (opcional, para limpiar)

    // devuelve payload para tu JS (precio, horario, meet_link genérico)


    public function requestBooking(Request $request, EmailBatch $batch)
    {
        // Solo dueño del batch
        if ((int)$batch->created_by !== (int)Auth::id()) {
            return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'item_id' => ['required', 'integer', 'min:1'],
        ]);

        $itemId = (int)$data['item_id'];
        $studentId = (int)Auth::id();

        return DB::transaction(function () use ($batch, $itemId, $studentId) {

            // 1) lock batch
            $b = EmailBatch::query()
                ->whereKey($batch->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Si ya existe booking para este batch, idempotente
            if (!empty($b->booking_id)) {
                $booking = DB::table('slot_bookings')->where('id', (int)$b->booking_id)->first();

                return response()->json([
                    'ok' => true,
                    'message' => 'Booking ya creado para este batch.',
                    'batch_id' => $b->id,
                    'booking' => $booking ? [
                        'id' => (int)$booking->id,
                        'status' => (int)$booking->status,
                        'start_time' => $booking->start_time,
                        'end_time' => $booking->end_time,
                        'session_fee' => $booking->session_fee,
                        'meeting_link' => $booking->meeting_link,
                    ] : null,
                ]);
            }

            // 2) lock item
            $item = EmailBatchItem::query()
                ->where('batch_id', $b->id)
                ->whereKey($itemId)
                ->lockForUpdate()
                ->first();

            if (!$item) {
                return response()->json(['ok' => false, 'message' => 'Item no pertenece al batch'], 404);
            }

            // Solo aceptados
            if ($item->status !== 'accepted') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Solo puedes solicitar un tutor que haya aceptado',
                    'current_status' => $item->status,
                ], 409);
            }

            $tutorId = (int)$item->user_id;

            // 3) horario automático
            $waitMinutes = 5;
            $sessionMinutes = 20;

            $startAt = now()->addMinutes($waitMinutes);
            $endAt   = (clone $startAt)->addMinutes($sessionMinutes);

            // 4) precio
            $precio = (float)DB::table('profiles')->where('user_id', $tutorId)->value('price');
            if ($precio <= 0) {
                return response()->json(['ok' => false, 'message' => 'Tutor sin precio configurado'], 422);
            }

            // 5) anti-solapamiento: si el tutor ya está reservado/activo en ese rango, no se puede
            $overlapExists = DB::table('slot_bookings')
                ->where('tutor_id', $tutorId)
                ->whereIn('status', [4, 1]) // 4 reserved, 1 active
                ->where(function ($q) use ($startAt, $endAt) {
                    // overlap: existing.start < newEnd AND existing.end > newStart
                    $q->where('start_time', '<', $endAt->toDateTimeString())
                        ->where('end_time',   '>', $startAt->toDateTimeString());
                })
                ->lockForUpdate()
                ->exists();

            if ($overlapExists) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Ese tutor ya fue reservado por otro estudiante. Elige otro.',
                ], 409);
            }

            // 6) meet link genérico (pruebas)
            $meetLink = 'https://meet.google.com/upy-mxim-nrm'; // o "/meet/booking/{$bookingId}" luego

            // 7) crear booking RESERVED(4)
            $bookingId = DB::table('slot_bookings')->insertGetId([
                'student_id' => $studentId,
                'tutor_id' => $tutorId,
                'subject_id' => (int)$b->subject_id,
                'user_subject_slot_id' => null,          // aquí no usamos slots por ahora
                'start_time' => $startAt->toDateTimeString(),
                'end_time' => $endAt->toDateTimeString(),
                'session_fee' => $precio,
                'booked_at' => now()->toDateTimeString(),
                'calendar_event_id' => null,
                'meeting_link' => $meetLink,
                'status' => 4, // ✅ reserved (esperando aprobación tutor)
                'meta_data' => json_encode([
                    'mode' => 'instant_auto',
                    'wait_minutes' => $waitMinutes,
                    'session_minutes' => $sessionMinutes,
                    'batch_id' => (int)$b->id,
                    'accepted_item_id' => (int)$item->id,
                ]),
            ]);



            // 8) marcar item "chosen" y batch "matched" + booking_id
            EmailBatchItem::query()
                ->whereKey($item->id)
                ->update([
                    'status' => 'chosen',
                    'chosen_at' => now(),
                    'updated_at' => now(),
                ]);

            EmailBatch::query()
                ->whereKey($b->id)
                ->update([
                    'status' => 'matched',
                    'accepted_user_id' => $tutorId,
                    'accepted_item_id' => (int)$item->id,
                    'accepted_at' => now(),
                    'booking_id' => $bookingId, // ✅ necesitas esta columna
                    'updated_at' => now(),
                ]);

            // 9) expirar otros items del batch (limpieza)
            EmailBatchItem::query()
                ->where('batch_id', $b->id)
                ->where('id', '!=', (int)$item->id)
                ->whereIn('status', ['pending', 'sending', 'sent', 'accepted'])
                ->update([
                    'status' => 'expired',
                    'last_error' => 'not_chosen',
                    'updated_at' => now(),
                ]);

            // 10) respuesta para tu JS (voltear card → mostrar QR y botón subir)
            return response()->json([
                'ok' => true,
                'message' => 'Booking creado. Sube comprobante para revisión del tutor.',
                'batch_id' => (int)$b->id,
                'item_id' => (int)$item->id,
                'booking' => [
                    'id' => (int)$bookingId,
                    'status' => 4,
                    'tutor_id' => $tutorId,
                    'student_id' => $studentId,
                    'subject_id' => (int)$b->subject_id,
                    'start_time' => $startAt->toDateTimeString(),
                    'end_time' => $endAt->toDateTimeString(),
                    'session_fee' => (float)$precio,
                    'meeting_link' => $meetLink,
                ],
            ]);
        });
    }


    public function studentMeet(Request $request, $booking)
{
    $studentId = (int) Auth::id();
    $bookingId = (int) $booking;

    $b = DB::table('slot_bookings')
        ->where('id', $bookingId)
        ->first();

    if (!$b) {
        abort(404, 'Booking no encontrado');
    }

    // Seguridad: solo el dueño (estudiante) puede abrir su meet
    if ((int)$b->student_id !== $studentId) {
        abort(403, 'Forbidden');
    }

    // Solo permitir si ya está aceptado (Active=1)
    if ((int)$b->status !== 1) {
        abort(409, 'Aún no está confirmada la tutoría');
    }

    $link = (string) ($b->meeting_link ?? '');

    // Si no hay link, usa el genérico (o aborta si prefieres)
    if ($link === '') {
        $link = env('MEET_GENERIC_LINK') ?: 'https://meet.google.com/upy-mxim-nrm';
    }

    return redirect()->away($link);
}
}
