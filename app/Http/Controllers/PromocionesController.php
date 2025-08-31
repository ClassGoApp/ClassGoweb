<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PromocionesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            // Redirigir al login o mostrar un error si no hay sesión iniciada
            return redirect()->route('login');
        }

        // Inicializar la variable $codigo con un valor por defecto
        $codigo = null;

        $cupon = Coupon::where('referencia', $user->id)->latest()->first();
        $codigo = $cupon->codigo;
        $cuponservice = new \App\Services\CuponesService();
        $cupones = $cuponservice->todosLosCupones($user);
        return view('livewire.pages.student.promociones', compact('codigo', 'cupones'));
    }
    public function canjear(Request $request)
    {
        $cuponservice = new \App\Services\CuponesService();
        $user = Auth::user();
        $codigo = trim($request->input('codigo'));
       


        if ( !$cuponservice->existeCupon($codigo) || $cuponservice->verificaUsoCupon($codigo, $user) ) {
            return redirect()->route('promociones')->with('error', 'Cupón no válido o en uso.');
        } else {
            
            $cupon = Coupon::where('codigo', $codigo)->first();
            UserCoupon::create(
                ['coupon_id' => $cupon->id, 'user_id' => $user->id],
                ['estado' => 'activo', 'cantidad' => $cupon->cantidad]
            );
        }


        return redirect()->route('promociones')->with('Exito', 'Cupón Cajeado con exito.');
    }
}
