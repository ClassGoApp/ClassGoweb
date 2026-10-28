<?php

namespace App\Http\Controllers;

use App\Models\EmailBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstantTutoringController extends Controller
{
    public function index(){
        return view('vistas.view.pages.pruebaInst');
    }

    public function waitingTutor(EmailBatch $batch)
    {
        if ((int) $batch->created_by !== (int) Auth::id()) {
            abort(403);
        }

        // Si ya hay un tutor aceptado/reservado o ya está en proceso de pago/reunión, 
        // no permitir volver a waiting-tutor, redirigir al flujo unificado
        if (in_array($batch->status, ['matched', 'done', 'processing'])) {
            return redirect()->route('tutorias-instantaneas', ['batch' => $batch->id]);
        }

        $tutor = null;
        if ($batch->target_tutor_id) {
            $tutor = DB::table('users as u')
                ->leftJoin('profiles as p', 'p.user_id', '=', 'u.id')
                ->where('u.id', $batch->target_tutor_id)
                ->first(['u.id', 'u.email', 'p.first_name', 'p.last_name', 'p.image', 'p.price']);
        }

        $subject = DB::table('subjects')->where('id', $batch->subject_id)->first(['id', 'name']);

        return view('vistas.view.pages.waiting-tutor', [
            'batch' => $batch,
            'tutor' => $tutor,
            'subject' => $subject,
        ]);
    }
}
