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

        $cupon = Coupon::where('referencia', $user->id)->latest()->first();
        $codigo = $cupon->codigo;
        $cupones = $user->coupons;
        //dd( $cupones);
        return view('livewire.pages.student.promociones', compact('codigo', 'cupones'));
    }
    public function canjear(Request $request)
    {
        $user = Auth::user();
        $codigo = trim($request->input('codigo'));
       
        $cupon = Coupon::where('codigo', $codigo)->first();
       
        if ($cupon->doesntExist()) {
            return redirect()->route('promociones')->with('error', 'Cupón no válido.');
        }
        if ($cupon->estado != 'activo') {
            return redirect()->route('promociones')->with('error', 'Cupón no está activo.');
        }
        UserCoupon::create(
            ['coupon_id' => $cupon->id, 'user_id' => $user->id],
            ['estado' => 'activo', 'cantidad' => $cupon->cantidad]
        );
        return redirect()->route('promociones');
    }
}
