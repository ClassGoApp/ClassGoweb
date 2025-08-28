<?php

namespace App\Services;


use App\Models\Code;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCoupon;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Str;
use App\Services\interfaces\ICuponesService;
use Validator;


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
        $cupones = $user->coupons()
            ->wherePivot('estado', 'activo')   // filtra SOLO por el pivote
            ->get();
        foreach ($cupones as $cupon) {
            if ($cupon->fecha_caducidad < now() || $cupon->cantidad <= 0) {
                // marcar como inactivo en el pivote
                $cupon->estado = 'inactivo';
                $cupon->save();
            }
        }

        return $cupones;
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

    function getCuponsByUserId($iduser){
        return UserCoupon::where('user_id', $iduser)->get();
    }



    /**
     *  funcion que crea el cupon para el usuario con n tutorias gratis
     * 
     * @param string $code
     * @param int $cantidadtutorias
     * @param User $user
     * @return void
     */


    function creatreCuponDescTutorias(Code $code,int $cantidadtutorias, User $user){

      if($cantidadtutorias){
        if($code){
           $code=Code::where('codigo',$code)->first();
            UserCoupon::create([
                    'coupon_id' => Coupon::create([
                        'code_id' => $code->id,
                        'descuento' => $code->descuento, // Descuento del 100%
                        'fecha_caducidad' => $code->fecha_caducidad, // Vence al final del siguiente mes
                        'estado' => 'activo',
                    ])->id,
                    'user_id' => $user->id,
                    'cantidad' => $cantidadtutorias,
                ]);
        }  
      }
    }



    function createCode(string $code){

        $validator = Validator::make(['codigo' => $code], [
            'codigo' => 'required|string|max:255|unique:codes',
        ]);

         if ($validator->fails()) {
             throw new ValidationException($validator);
         }

        return Code::create([
            'codigo' => $code,
            'user_id' => auth()->id(),
        ]);

    }

   
    function cobrarcupon($userid,$cuponid){

        $user = User::find($userid);
        $coupon = Coupon::find($cuponid);
        $usercupon = UserCoupon::where('user_id', $user->id)->where('coupon_id', $coupon->id)->first();

        if (!$usercupon) {
           return null;
        }
        else {
            $usercupon->cantidad=$usercupon->cantidad-1;
            $usercupon->save();
            return $usercupon;
        }
    }


}
