<?php

namespace App\Services\interfaces;

use App\Models\Code;
use App\Models\User;

interface ICuponesService
{


  public function generaCodigoCupon($user);
  /**
   * 
   * funcion que genera el cupon de 
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
  public function asignacionCuponInvitacion($cupon, $user);
  /**
   * 
   * Funcion que asigna el cupon de invitacion
   * al dueño del cupon
   * 
   */
  public function asignacionCuponDuenio($cupon);

  /**
   * 
   * Funcion que asigan el 
   * cupon de bienvenida
   * 
   */
  public function asignacionCuponBienvenida($user);

  /**
   * funcion que genera cupon con parametros
   */
  public function cuponesGenerales($request);

  /**
   * funcion muestra los cupones del usuario
   *
   */
  public function todosLosCupones($user);

  /**
   * Verifica si el cupon es valido
   */
  public  function existeCupon($codigo): bool;
  /**
   * funcion que canjea el cupon
   */
  public function canjeaCupon($codigo, $user);
  /**
   * funcion que mmuestra el porcentaje del cupon
   */
  public function porcentajeCupon($codigo);
  /**
   * funcion que completa el uso del cupon
   */
  public function cuponCanjeado($codigo, $user);
}
