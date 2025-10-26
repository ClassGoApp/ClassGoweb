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
     * Obtener métodos de pago QR del usuario autenticado
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQrPayoutMethods(Request $request)
    {
        try {
            $user = Auth::user();
            
            $qrPayoutMethods = UserPayoutMethod::where('user_id', $user->id)
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
     * Crear nuevo método de pago QR
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeQrPayoutMethod(Request $request)
    {
        try {
            $request->validate([
                'img_qr' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
                'payout_details' => 'nullable|array',
            ]);

            $user = Auth::user();

            // Desactivar otros métodos de pago del usuario
            UserPayoutMethod::where('user_id', $user->id)
                ->update(['status' => 'inactive']);

            // Generar nombre único para la imagen
            $fileName = uniqid() . '_' . $request->file('img_qr')->getClientOriginalName();
            
            // Crear directorio si no existe
            $destinationPath = public_path('storage/qr_codes');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Mover la imagen al directorio correcto
            $request->file('img_qr')->move($destinationPath, $fileName);
            
            // Guardar solo la ruta relativa en la base de datos
            $imgQrPath = 'qr_codes/' . $fileName;

            // Crear el método de pago QR
            $qrPayoutMethod = UserPayoutMethod::create([
                'user_id' => $user->id,
                'payout_method' => 'QR',
                'img_qr' => $imgQrPath,
                'payout_details' => $request->payout_details ?? null,
                'status' => 'active',
            ]);

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
                message: 'Método de pago QR creado exitosamente',
                data: $data
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error(
                data: null,
                message: 'Error de validación: ' . implode(', ', $e->errors()),
                code: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $e) {
            Log::error('Error al crear método de pago QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al crear método de pago QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Actualizar método de pago QR existente
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQrPayoutMethod(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            $qrPayoutMethod = UserPayoutMethod::where('id', $id)
                ->where('user_id', $user->id)
                ->where('payout_method', 'QR')
                ->whereNull('deleted_at')
                ->first();

            if (!$qrPayoutMethod) {
                return $this->error(
                    data: null,
                    message: 'Método de pago QR no encontrado',
                    code: Response::HTTP_NOT_FOUND
                );
            }

            $request->validate([
                'img_qr' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
                'payout_details' => 'nullable|array',
            ]);

            // Si se envía una nueva imagen
            if ($request->hasFile('img_qr')) {
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
            }

            // Actualizar otros campos si se proporcionan
            if ($request->has('payout_details')) {
                $qrPayoutMethod->payout_details = $request->payout_details;
            }

            $qrPayoutMethod->save();

            $data = [
                'id' => $qrPayoutMethod->id,
                'user_id' => $qrPayoutMethod->user_id,
                'payout_method' => $qrPayoutMethod->payout_method,
                'img_qr' => $qrPayoutMethod->img_qr,
                'img_qr_url' => $qrPayoutMethod->img_qr ? url('public/storage/' . $qrPayoutMethod->img_qr) : null,
                'payout_details' => $qrPayoutMethod->payout_details,
                'status' => $qrPayoutMethod->status,
                'created_at' => $qrPayoutMethod->created_at,
                'updated_at' => $qrPayoutMethod->updated_at,
            ];

            return $this->success(
                message: 'Método de pago QR actualizado exitosamente',
                data: $data
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error(
                data: null,
                message: 'Error de validación: ' . implode(', ', $e->errors()),
                code: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $e) {
            Log::error('Error al actualizar método de pago QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al actualizar método de pago QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Eliminar método de pago QR
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteQrPayoutMethod(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            $qrPayoutMethod = UserPayoutMethod::where('id', $id)
                ->where('user_id', $user->id)
                ->where('payout_method', 'QR')
                ->whereNull('deleted_at')
                ->first();

            if (!$qrPayoutMethod) {
                return $this->error(
                    data: null,
                    message: 'Método de pago QR no encontrado',
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
                message: 'Método de pago QR eliminado exitosamente',
                data: null
            );

        } catch (\Exception $e) {
            Log::error('Error al eliminar método de pago QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al eliminar método de pago QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Obtener un método de pago QR específico
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQrPayoutMethod(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            $qrPayoutMethod = UserPayoutMethod::where('id', $id)
                ->where('user_id', $user->id)
                ->where('payout_method', 'QR')
                ->whereNull('deleted_at')
                ->first();

            if (!$qrPayoutMethod) {
                return $this->error(
                    data: null,
                    message: 'Método de pago QR no encontrado',
                    code: Response::HTTP_NOT_FOUND
                );
            }

            $data = [
                'id' => $qrPayoutMethod->id,
                'user_id' => $qrPayoutMethod->user_id,
                'payout_method' => $qrPayoutMethod->payout_method,
                'img_qr' => $qrPayoutMethod->img_qr,
                'img_qr_url' => $qrPayoutMethod->img_qr ? url('public/storage/' . $qrPayoutMethod->img_qr) : null,
                'payout_details' => $qrPayoutMethod->payout_details,
                'status' => $qrPayoutMethod->status,
                'created_at' => $qrPayoutMethod->created_at,
                'updated_at' => $qrPayoutMethod->updated_at,
            ];

            return $this->success(
                message: 'Método de pago QR obtenido exitosamente',
                data: $data
            );

        } catch (\Exception $e) {
            Log::error('Error al obtener método de pago QR: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error al obtener método de pago QR',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
