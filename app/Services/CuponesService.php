<?php

namespace App\Services;


use App\Models\Code;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Support\Str;
use App\Services\interfaces\ICuponesService;


class CuponesService implements ICuponesService
{
    /**
     * Metodo Generar el Codigo del Cupon
     * @param mixed $user
     */

    public function generaCodigoCupon($user)
    {
        $id = (string) $user->id; // Convertimos a string
        $longitudId = strlen($id);
        $longitudTotal = 8;

        // Letras posibles
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';

        // Cantidad de letras aleatorias necesarias
        $faltantes = $longitudTotal - $longitudId;

        for ($i = 0; $i < $faltantes; $i++) {
            $codigo .= $chars[random_int(0, strlen($chars) - 1)];
        }

        // Al final agregamos el ID
        $codigo .= $id;

        return $codigo;
    }

    /**
     * Genera el Cupon de Invitacion 
     * al momento de registrarse
     */
    public function generaCuponInvitacion($user)
    {
        Coupon::create([
            'nombre' => 'Cupon de Invitacion ' . $user->profile->first_name,
            'codigo' => $this->generaCodigoCupon($user),
            'fecha_caducidad' => now()->addMonthsNoOverflow(3)->toDateString(),
            'estado' => 'inactivo',
            'descuento' => 100,
            'cantidad' => 1,
            'referencia' => $user->id,
        ]);
    }

    /**
     * Metodo asigna cupon de invitacion
     *  a usuario recien registrado
     */

    function asignacionCuponInvitacion($cupon, $user)
    {
        UserCoupon::firstOrCreate(
            ['coupon_id' => $cupon->id, 'user_id' => $user->id],
            ['estado' => 'activo', 'cantidad' => $cupon->cantidad]
        );
    }
    /**
     * Metodo asigna cupon de invitacion
     * a usuario dueno del cupon
     */

    function asignacionCuponDuenio($cupon)
    {
        UserCoupon::firstOrCreate(
            ['coupon_id' => $cupon->id, 'user_id' => $cupon->referencia],
            ['estado' => 'activo', 'cantidad' => $cupon->cantidad]
        );
    }


    /**
     * asigna cupon de bienvenida
     */
    function asignacionCuponBienvenida($user)
    {
        $cupon = Coupon::where('codigo', 'CLASSGO1')->first();

        UserCoupon::firstOrCreate(
            ['coupon_id' => $cupon->id, 'user_id' => $user->id],
            ['estado' => 'activo', 'cantidad' => $cupon->cantidad]
        );
    }
    /**
     * funcion que genera cupones con parametros
     */
    function cuponesGenerales($request)
    {
        $cupon = Coupon::create([
            'nombre' => $request['nombre'],
            'codigo' => $request['codigo'],
            'fecha_caducidad' => $request['fecha_caducidad'],
            'estado' => 'activo',
            'descuento' => $request['descuento'],
            'cantidad' => $request['cantidad'],
            'referencia' => 0,
        ]);
    }
    /**
     * funcion que muestra todos los cupones del usuario
     */
    public function todosLosCupones($user)
    {
        
        return $user->coupons()
            ->wherePivot('estado', 'activo')   // filtra SOLO por el pivote
            ->get();
    }

    /**
     * funcion que verifica si el cupon es valido
     * @return bool
     */

    public function existeCupon($codigo): bool
    {
        return Coupon::where('codigo', $codigo)->exists();
    }


    /**
     * funcion que canjea el cupon
     */
    public function canjeaCupon($codigo, $user)
    {

        $cupon = Coupon::where('codigo', $codigo)->first();
        UserCoupon::firstOrCreate(
            ['coupon_id' => $cupon->id, 'user_id' => $user->id],
            ['estado' => 'activo', 'cantidad' => $cupon->cantidad]
        );
    }
    /**
     * funcion que muestra el porcentaje del cupon
     */
    public function porcentajeCupon($codigo)
    {
        $cupon = Coupon::where('codigo', $codigo)->first();
        return $cupon->descuento;
    }
    /**
     * funcion que completa el uso del cupon
     */
    public function cuponCanjeado($codigo, $user)
    {
        $cuponOriginal = Coupon::where('codigo', $codigo)->first();
        $cuponCanjeado = UserCoupon::where('coupon_id', $cuponOriginal->id)
            ->where('user_id', $user->id)
            ->first();
        $cuponCanjeado->cantidad = $cuponCanjeado->cantidad - 1;
        if( $cuponCanjeado->cantidad <=0){
            $cuponCanjeado->estado = 'inactivo';
        }
          $cuponCanjeado->save();
    }
}
