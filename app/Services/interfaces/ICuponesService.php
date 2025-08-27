<?php

namespace App\Services\interfaces;
use App\Models\Code;
use App\Models\User;

interface ICuponesService{



    function codeFriendly($code, $user);

    /**
     *  funcion que agrega un codigo al usuario que se registra
     *  y 5 cupones desabilitados mientras no se verifique
     */
    function codeCoupons($user);

    /**
     * funcion que agrega un cupon al usuario que ingresa el codigo promocional
     * 
     * 
     * @param  Code $code
     * @param  User $user
     */
    function cupomcodigorandom($code, $user,);


/**
 * 
 * funcion que genera el codigo del cupon
 * 
 */
public function generaCodigoCupon($user);
/**
 * 
 * fumncion que genera el cupon de 
 * invitacion al momento del registro
 * 
 */
public function generaCuponInvitacion($user);
  /**
   * 
   * funcion que asigna el cupon de
   * invitacion al usuario recien registrado
   * 
   */
  function asignacionCuponInvitacion($cupon, $user);
  /**
   * 
   * Funcion que asigna el cupon de invitacion
   * al dueño del cupon
   * 
   */
  function asignacionCuponDuenio($cupon);

  /**
   * 
   * Funcion que asigan el 
   * cupon de bienvenida
   * 
   */
  function asignacionCuponBienvenida($user);

 /**
  * funcion que genera cupon con parametros
  */
 function cuponesGenerales($request);
}