<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPayoutMethod;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class QrPayoutController extends Controller
{
    use ApiResponser;

    /**
     * Obtener métodos de pago QR del usuario
     * @param Request $request
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQrPayoutMethods(Request $request, $user_id)
    {
        try {
            $qrPayoutMethods = UserPayoutMethod::where('user_id', $user_id)
                ->where('payout_method', 'QR')
                ->whereNull('deleted_at')
                ->get();

            $data = $qrPayoutMethods->map(function ($method) {
                return [
                    'id' => $method->id,
                    'user_id' => $method->user_id,
                    'payout_method' => $method->payout_method,
                    'img_qr' => $method->img_qr,
                    'img_qr_url' => $method->img_qr ? url('public/storage/' . $method->img_qr) : null,
                    'payout_details' => $method->payout_details,
                    'status' => $method->status,
                    'created_at' => $method->created_at,
                    'updated_at' => $method->updated_at,
                ];
            });

            return $this->success(
                message: 'Métodos de pago QR obtenidos exitosamente',
                data: $data
            );

        } catch (\Exception $e) {
            Log::error('Error al obtener métodos de pago QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al obtener métodos de pago QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Crear nuevo método de pago QR (tutor sube su imagen QR)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeQrPayoutMethod(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'img_qr' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            ]);

            $user_id = $request->user_id;

            // Verificar si el usuario ya tiene un método QR activo
            $existingQr = UserPayoutMethod::where('user_id', $user_id)
                ->where('payout_method', 'QR')
                ->whereNull('deleted_at')
                ->first();

            if ($existingQr) {
                // Eliminar la imagen anterior si existe
                if ($existingQr->img_qr && file_exists(public_path('storage/' . $existingQr->img_qr))) {
                    unlink(public_path('storage/' . $existingQr->img_qr));
                }
                
                // Actualizar el registro existente
                $fileName = uniqid() . '_' . $request->file('img_qr')->getClientOriginalName();
                
                // Crear directorio si no existe
                $destinationPath = public_path('storage/qr_codes');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                // Mover la imagen al directorio correcto
                $request->file('img_qr')->move($destinationPath, $fileName);
                
                // Actualizar el registro existente
                $existingQr->img_qr = 'qr_codes/' . $fileName;
                $existingQr->status = 'active';
                $existingQr->save();
                
                $qrPayoutMethod = $existingQr;
            } else {
                // Crear nuevo registro
                $fileName = uniqid() . '_' . $request->file('img_qr')->getClientOriginalName();
                
                // Crear directorio si no existe
                $destinationPath = public_path('storage/qr_codes');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                // Mover la imagen al directorio correcto
                $request->file('img_qr')->move($destinationPath, $fileName);
                
                // Crear el método de pago QR
                $qrPayoutMethod = UserPayoutMethod::create([
                    'user_id' => $user_id,
                    'payout_method' => 'QR',
                    'img_qr' => 'qr_codes/' . $fileName,
                    'payout_details' => null,
                    'status' => 'active',
                ]);
            }

            $data = [
                'id' => $qrPayoutMethod->id,
                'user_id' => $qrPayoutMethod->user_id,
                'payout_method' => $qrPayoutMethod->payout_method,
                'img_qr' => $qrPayoutMethod->img_qr,
                'img_qr_url' => url('public/storage/' . $qrPayoutMethod->img_qr),
                'payout_details' => $qrPayoutMethod->payout_details,
                'status' => $qrPayoutMethod->status,
                'created_at' => $qrPayoutMethod->created_at,
                'updated_at' => $qrPayoutMethod->updated_at,
            ];

            return $this->success(
                message: 'Imagen QR guardada exitosamente',
                data: $data
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error(
                data: null,
                message: 'Error de validación: ' . implode(', ', $e->errors()),
                code: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $e) {
            Log::error('Error al guardar imagen QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al guardar imagen QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Actualizar imagen QR del tutor (reemplaza la existente)
     * @param Request $request
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQrPayoutMethod(Request $request, $user_id)
    {
        try {
            $qrPayoutMethod = UserPayoutMethod::where('user_id', $user_id)
                ->where('payout_method', 'QR')
                ->whereNull('deleted_at')
                ->first();

            if (!$qrPayoutMethod) {
                return $this->error(
                    data: null,
                    message: 'No se encontró imagen QR para este usuario',
                    code: Response::HTTP_NOT_FOUND
                );
            }

            $request->validate([
                'img_qr' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            ]);

            // Eliminar la imagen anterior si existe
            if ($qrPayoutMethod->img_qr && file_exists(public_path('storage/' . $qrPayoutMethod->img_qr))) {
                unlink(public_path('storage/' . $qrPayoutMethod->img_qr));
            }

            // Generar nombre único para la nueva imagen
            $fileName = uniqid() . '_' . $request->file('img_qr')->getClientOriginalName();
            
            // Crear directorio si no existe
            $destinationPath = public_path('storage/qr_codes');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Mover la nueva imagen al directorio correcto
            $request->file('img_qr')->move($destinationPath, $fileName);
            
            // Actualizar la ruta en la base de datos
            $qrPayoutMethod->img_qr = 'qr_codes/' . $fileName;
            $qrPayoutMethod->save();

            $data = [
                'id' => $qrPayoutMethod->id,
                'user_id' => $qrPayoutMethod->user_id,
                'payout_method' => $qrPayoutMethod->payout_method,
                'img_qr' => $qrPayoutMethod->img_qr,
                'img_qr_url' => url('public/storage/' . $qrPayoutMethod->img_qr),
                'payout_details' => $qrPayoutMethod->payout_details,
                'status' => $qrPayoutMethod->status,
                'created_at' => $qrPayoutMethod->created_at,
                'updated_at' => $qrPayoutMethod->updated_at,
            ];

            return $this->success(
                message: 'Imagen QR actualizada exitosamente',
                data: $data
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error(
                data: null,
                message: 'Error de validación: La imagen QR es obligatoria',
                code: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $e) {
            Log::error('Error al actualizar imagen QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al actualizar imagen QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Eliminar imagen QR del tutor (elimina el único registro del usuario)
     * @param Request $request
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteQrPayoutMethod(Request $request, $user_id)
    {
        try {
            $qrPayoutMethod = UserPayoutMethod::where('user_id', $user_id)
                ->where('payout_method', 'QR')
                ->whereNull('deleted_at')
                ->first();

            if (!$qrPayoutMethod) {
                return $this->error(
                    data: null,
                    message: 'No se encontró imagen QR para este usuario',
                    code: Response::HTTP_NOT_FOUND
                );
            }

            // Eliminar la imagen del servidor si existe
            if ($qrPayoutMethod->img_qr && file_exists(public_path('storage/' . $qrPayoutMethod->img_qr))) {
                unlink(public_path('storage/' . $qrPayoutMethod->img_qr));
            }

            // Eliminar el registro (soft delete)
            $qrPayoutMethod->delete();

            return $this->success(
                message: 'Imagen QR eliminada exitosamente',
                data: null
            );

        } catch (\Exception $e) {
            Log::error('Error al eliminar imagen QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al eliminar imagen QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Obtener imagen QR específica del tutor
     * @param Request $request
     * @param int $user_id
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQrPayoutMethod(Request $request, $user_id, $id)
    {
        try {
            $qrPayoutMethod = UserPayoutMethod::where('id', $id)
                ->where('user_id', $user_id)
                ->where('payout_method', 'QR')
                ->whereNull('deleted_at')
                ->first();

            if (!$qrPayoutMethod) {
                return $this->error(
                    data: null,
                    message: 'Imagen QR no encontrada',
                    code: Response::HTTP_NOT_FOUND
                );
            }

            $data = [
                'id' => $qrPayoutMethod->id,
                'user_id' => $qrPayoutMethod->user_id,
                'payout_method' => $qrPayoutMethod->payout_method,
                'img_qr' => $qrPayoutMethod->img_qr,
                'img_qr_url' => url('public/storage/' . $qrPayoutMethod->img_qr),
                'payout_details' => $qrPayoutMethod->payout_details,
                'status' => $qrPayoutMethod->status,
                'created_at' => $qrPayoutMethod->created_at,
                'updated_at' => $qrPayoutMethod->updated_at,
            ];

            return $this->success(
                message: 'Imagen QR obtenida exitosamente',
                data: $data
            );

        } catch (\Exception $e) {
            Log::error('Error al obtener imagen QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al obtener imagen QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
