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
        //$codigo .= $id;
        $codigo = 1;

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
     * Codigo de invitacion
     */
    function codeFriendly($code, $user)
    {
        if ($code->user_id) {
            UserCoupon::create([
                'coupon_id' => Coupon::create([
                    'code_id' => $code->id,
                    'descuento' => 100, // Descuento del 100%
                    'fecha_caducidad' => now()->endOfMonth(), // Vence al final del siguiente mes
                    'estado' => 'activo',
                ])->id,
                'user_id' => $code->user_id,
                'cantidad' => 1,
            ]);
            if ($user) {
                UserCoupon::create([
                    'coupon_id' => Coupon::create([
                        'code_id' => $code->id,
                        'descuento' => 100, // Descuento del 100%
                        'fecha_caducidad' => now()->endOfMonth(), // Vence al final del siguiente mes
                        'estado' => 'activo',
                    ])->id,
                    'user_id' => $user->id,
                    'cantidad' => 1,
                ]);
            }
        }
    }

    /**
     * Crea el codigo
     */
    function codeCoupons($user)
    {
        UserCoupon::create([
            'coupon_id' => Coupon::create([
                'code_id' =>
                Code::create([
                    'nombre' => 'Código de bienvenida',
                    'codigo' => Str::random(8), // Generar un código único
                    'user_id' => $user->id,
                    'fecha_caducidad' => null,
                    'descuento' => 100, // Descuento del 100%
                ])->id,
                'descuento' => 100, // Descuento del 100%
                'fecha_caducidad' => now()->endOfMonth(), // Vence al final del siguiente mes
                'estado' => 'inactivo',
            ])->id,
            'user_id' => $user->id,
            'cantidad' => 5,
        ]);
    }
    /**
     * Codigo aleatorio
     */
    function cupomcodigorandom($code, $user)
    {
        if ($code) {
            if (!$code->user_id) {
                // añade 5 a ti
                UserCoupon::create([
                    'coupon_id' => Coupon::create([
                        'code_id' => $code->id,
                        'descuento' => $code->descuento, // Descuento del 100%
                        'fecha_caducidad' => $code->fecha_caducidad, // Vence al final del siguiente mes
                        'estado' => 'activo',
                    ])->id,
                    'user_id' => $user->id,
                    'cantidad' => 1,
                ]);
            }
        }
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
}
