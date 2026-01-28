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
        return DB::table('user_subject as us')
            ->join('users as u', 'u.id', '=', 'us.user_id')
            ->leftJoin('user_reviews as ur', 'ur.user_id', '=', 'us.user_id')
            ->leftJoin('reviews as r', function ($join) {
                $join->on('r.id', '=', 'ur.review_id');
                // ->where('r.status', '=', 'active');
            })
            ->where('us.subject_id', $subjectId)
            // ->where('us.status', 'active')
            ->whereNotNull('u.email')
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('user_subject_slots as s')
                    ->whereColumn('s.user_id', 'us.user_id')
                    ->whereRaw('s.date = CURDATE()')
                    ->whereRaw('s.start_time <= CURTIME()')
                    ->whereRaw('s.end_time > CURTIME()');
            })
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
        return DB::table('user_subject as us')
            ->join('users as u', 'u.id', '=', 'us.user_id')
            ->leftJoin('user_reviews as ur', 'ur.user_id', '=', 'us.user_id')
            ->leftJoin('reviews as r', function ($join) {
                $join->on('r.id', '=', 'ur.review_id');
                // ->where('r.status', '=', 'active');
            })
            ->where('us.subject_id', $subjectId)
            // ->where('us.status', 'active')
            ->whereNotNull('u.email')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('user_subject_slots as s')
                    ->whereColumn('s.user_id', 'us.user_id')
                    ->whereRaw('s.date = CURDATE()')
                    ->whereRaw('s.start_time <= CURTIME()')
                    ->whereRaw('s.end_time > CURTIME()');
            })
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


        // ⬅️ define tu tiempo de espera real
        $timeoutMinutes = 10;

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
                'status' => 'pending',
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
        // (opcional) seguridad: solo el dueño del batch puede ver
        if ((int)$batch->created_by !== (int) Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $items = EmailBatchItem::query()
            ->where('batch_id', $batch->id)
            ->orderBy('position')
            ->limit(200) // suficiente para debug local
            ->get()
            ->map(function ($it) {
                $email = DB::table('users')->where('id', $it->user_id)->value('email');

                return [
                    'id' => $it->id,
                    'position' => $it->position,
                    'user_id' => $it->user_id,
                    'email' => $email,
                    'status' => $it->status,
                    'sent_at' => optional($it->sent_at)->toDateTimeString(),
                    'last_error' => $it->last_error,
                ];
            });

        $queued = EmailBatchItem::query()
            ->where('batch_id', $batch->id)
            ->count();

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
            ],
            'items' => $items,
        ]);
    }


    // public function active()
    // {
    //     $batchId = session('active_batch_id');

    //     if (!$batchId) {
    //         return response()->json(['active' => false]);
    //     }

    //     $batch = EmailBatch::query()->find($batchId);

    //     if (!$batch || in_array($batch->status, ['done', 'failed'], true)) {
    //         session()->forget(['active_batch_id', 'active_subject_id']);
    //         return response()->json(['active' => false]);
    //     }

    //     return response()->json([
    //         'active' => true,
    //         'batch_id' => $batch->id,
    //         'subject_id' => $batch->subject_id,
    //         'status' => $batch->status,
    //         'sent_count' => $batch->sent_count,
    //         'batch_size' => $batch->batch_size,
    //         'expires_at' => optional($batch->expires_at)->toDateTimeString(),
    //     ]);
    // }

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

        // 4) Mostrar vista "En espera..."
        return view('vistas.view.pages.waitlistTutor', [
            'status' => 'ok',
            'batch_id' => $batch->id,
            'subject_id' => $batch->subject_id,
        ]);
    }

    public function acceptedTutors(Request $request, EmailBatch $batch)
    {
        // seguridad: solo el dueño ve su batch
        if ((int)$batch->created_by !== (int) Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $afterId = (int) $request->query('after_id', 0);
        $limit   = max(1, min((int)$request->query('limit', 20), 50));

        $rows = DB::table('email_batch_items as ebi')
            ->join('users as u', 'u.id', '=', 'ebi.user_id')
            ->leftJoin('profiles as p', 'p.user_id', '=', 'ebi.user_id')
            ->leftJoin('user_reviews as ur', 'ur.user_id', '=', 'ebi.user_id')
            ->leftJoin('reviews as r', function ($join) {
                $join->on('r.id', '=', 'ur.review_id')
                    ->where('r.status', '=', 'active');
            })
            ->where('ebi.batch_id', $batch->id)
            ->whereNotNull('ebi.accepted_at')
            ->where('ebi.id', '>', $afterId)
            ->groupBy(
                'ebi.id',
                'ebi.user_id',
                'ebi.accepted_at',
                'u.email',
                'p.first_name',
                'p.last_name',
                'p.image',
                'p.verified_at',
                'p.price'
            )
            ->orderBy('ebi.id')
            ->limit($limit)
            ->select([
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

                DB::raw('ROUND(COALESCE(AVG(r.rating), 0), 1) as rating'),
            ])
            ->get();

        return response()->json([
            'batch_id' => $batch->id,
            'count' => $rows->count(),
            'data' => $rows,
            'next_after_id' => $rows->last()->id ?? $afterId,
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
}
