<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserCouponController extends Controller
{
    use ApiResponser;

    /**
     * Obtener todos los cupones de un usuario por su ID
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getUserCoupons(Request $request)
    {
        try {
            // Validar que se proporcione el user_id
            $request->validate([
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $userId = $request->input('user_id');

            Log::info('UserCouponController::getUserCoupons - Iniciando', [
                'user_id' => $userId
            ]);

            // Consulta para obtener los cupones del usuario con todos los campos de la tabla coupons
            $userCoupons = DB::table('user_coupons')
                ->join('coupons', 'user_coupons.coupon_id', '=', 'coupons.id')
                ->where('user_coupons.user_id', $userId)
                ->select(
                    // Campos de user_coupons
                    'user_coupons.id as user_coupon_id',
                    'user_coupons.user_id',
                    'user_coupons.coupon_id',
                    'user_coupons.estado as user_coupon_estado',
                    'user_coupons.cantidad as user_coupon_cantidad',
                    'user_coupons.created_at as user_coupon_created_at',
                    'user_coupons.updated_at as user_coupon_updated_at',
                    
                    // Todos los campos de coupons
                    'coupons.id as coupon_id',
                    'coupons.nombre as coupon_nombre',
                    'coupons.codigo as coupon_codigo',
                    'coupons.fecha_caducidad as coupon_fecha_caducidad',
                    'coupons.estado as coupon_estado',
                    'coupons.descuento as coupon_descuento',
                    'coupons.cantidad as coupon_cantidad',
                    'coupons.referencia as coupon_referencia',
                    'coupons.created_at as coupon_created_at',
                    'coupons.updated_at as coupon_updated_at'
                )
                ->orderBy('user_coupons.created_at', 'desc')
                ->get();

            Log::info('UserCouponController::getUserCoupons - Cupones encontrados', [
                'user_id' => $userId,
                'total_cupones' => $userCoupons->count()
            ]);

            // Formatear la respuesta
            $formattedCoupons = $userCoupons->map(function ($coupon) {
                return [
                    'user_coupon' => [
                        'id' => $coupon->user_coupon_id,
                        'user_id' => $coupon->user_id,
                        'coupon_id' => $coupon->coupon_id,
                        'estado' => $coupon->user_coupon_estado,
                        'cantidad' => $coupon->user_coupon_cantidad,
                        'created_at' => $coupon->user_coupon_created_at,
                        'updated_at' => $coupon->user_coupon_updated_at,
                    ],
                    'coupon_details' => [
                        'id' => $coupon->coupon_id,
                        'nombre' => $coupon->coupon_nombre,
                        'codigo' => $coupon->coupon_codigo,
                        'fecha_caducidad' => $coupon->coupon_fecha_caducidad,
                        'estado' => $coupon->coupon_estado,
                        'descuento' => $coupon->coupon_descuento,
                        'cantidad' => $coupon->coupon_cantidad,
                        'referencia' => $coupon->coupon_referencia,
                        'created_at' => $coupon->coupon_created_at,
                        'updated_at' => $coupon->coupon_updated_at,
                    ],
                    'status_info' => [
                        'user_coupon_active' => $coupon->user_coupon_estado === 'activo',
                        'coupon_active' => $coupon->coupon_estado === 'activo',
                        'is_expired' => $coupon->coupon_fecha_caducidad ? 
                            now()->isAfter($coupon->coupon_fecha_caducidad) : false,
                        'can_use' => $coupon->user_coupon_estado === 'activo' && 
                                   $coupon->coupon_estado === 'activo' && 
                                   (!$coupon->coupon_fecha_caducidad || now()->isBefore($coupon->coupon_fecha_caducidad))
                    ]
                ];
            });

            return $this->success(
                data: [
                    'user_id' => $userId,
                    'total_coupons' => $userCoupons->count(),
                    'coupons' => $formattedCoupons
                ],
                message: 'Cupones del usuario obtenidos exitosamente'
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('UserCouponController::getUserCoupons - Error de validación', [
                'errors' => $e->errors()
            ]);

            return $this->error(
                message: 'Error de validación: ' . implode(', ', array_flatten($e->errors())),
                data: null,
                code: 422
            );

        } catch (\Exception $e) {
            Log::error('UserCouponController::getUserCoupons - Error general', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error(
                message: 'Error al obtener cupones del usuario: ' . $e->getMessage(),
                data: null,
                code: 500
            );
        }
    }

    /**
     * Obtener un cupón específico de un usuario
     *
     * @param Request $request
     * @param int $userCouponId
     * @return \Illuminate\Http\Response
     */
    public function getUserCoupon(Request $request, $userCouponId)
    {
        try {
            Log::info('UserCouponController::getUserCoupon - Iniciando', [
                'user_coupon_id' => $userCouponId
            ]);

            // Consulta para obtener un cupón específico del usuario
            $userCoupon = DB::table('user_coupons')
                ->join('coupons', 'user_coupons.coupon_id', '=', 'coupons.id')
                ->where('user_coupons.id', $userCouponId)
                ->select(
                    // Campos de user_coupons
                    'user_coupons.id as user_coupon_id',
                    'user_coupons.user_id',
                    'user_coupons.coupon_id',
                    'user_coupons.estado as user_coupon_estado',
                    'user_coupons.cantidad as user_coupon_cantidad',
                    'user_coupons.created_at as user_coupon_created_at',
                    'user_coupons.updated_at as user_coupon_updated_at',
                    
                    // Todos los campos de coupons
                    'coupons.id as coupon_id',
                    'coupons.nombre as coupon_nombre',
                    'coupons.codigo as coupon_codigo',
                    'coupons.fecha_caducidad as coupon_fecha_caducidad',
                    'coupons.estado as coupon_estado',
                    'coupons.descuento as coupon_descuento',
                    'coupons.cantidad as coupon_cantidad',
                    'coupons.referencia as coupon_referencia',
                    'coupons.created_at as coupon_created_at',
                    'coupons.updated_at as coupon_updated_at'
                )
                ->first();

            if (!$userCoupon) {
                return $this->error(
                    message: 'Cupón no encontrado',
                    data: null,
                    code: 404
                );
            }

            // Formatear la respuesta
            $formattedCoupon = [
                'user_coupon' => [
                    'id' => $userCoupon->user_coupon_id,
                    'user_id' => $userCoupon->user_id,
                    'coupon_id' => $userCoupon->coupon_id,
                    'estado' => $userCoupon->user_coupon_estado,
                    'cantidad' => $userCoupon->user_coupon_cantidad,
                    'created_at' => $userCoupon->user_coupon_created_at,
                    'updated_at' => $userCoupon->user_coupon_updated_at,
                ],
                'coupon_details' => [
                    'id' => $userCoupon->coupon_id,
                    'nombre' => $userCoupon->coupon_nombre,
                    'codigo' => $userCoupon->coupon_codigo,
                    'fecha_caducidad' => $userCoupon->coupon_fecha_caducidad,
                    'estado' => $userCoupon->coupon_estado,
                    'descuento' => $userCoupon->coupon_descuento,
                    'cantidad' => $userCoupon->coupon_cantidad,
                    'referencia' => $userCoupon->coupon_referencia,
                    'created_at' => $userCoupon->coupon_created_at,
                    'updated_at' => $userCoupon->coupon_updated_at,
                ],
                'status_info' => [
                    'user_coupon_active' => $userCoupon->user_coupon_estado === 'activo',
                    'coupon_active' => $userCoupon->coupon_estado === 'activo',
                    'is_expired' => $userCoupon->coupon_fecha_caducidad ? 
                        now()->isAfter($userCoupon->coupon_fecha_caducidad) : false,
                    'can_use' => $userCoupon->user_coupon_estado === 'activo' && 
                               $userCoupon->coupon_estado === 'activo' && 
                               (!$userCoupon->coupon_fecha_caducidad || now()->isBefore($userCoupon->coupon_fecha_caducidad))
                ]
            ];

            return $this->success(
                data: $formattedCoupon,
                message: 'Cupón del usuario obtenido exitosamente'
            );

        } catch (\Exception $e) {
            Log::error('UserCouponController::getUserCoupon - Error', [
                'user_coupon_id' => $userCouponId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error(
                message: 'Error al obtener cupón del usuario: ' . $e->getMessage(),
                data: null,
                code: 500
            );
        }
    }
}
