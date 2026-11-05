<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamMember;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $team = TeamMember::where('status', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $team->map(function ($member) use ($request) {
                $photoUrl = null;
                $photoBase64 = null;

                if (!empty($member->photo)) {
                    $cleanPath = ltrim($member->photo, '/');
                    // Construir URL usando el host actual de la petición para que funcione en red local / móvil
                    $photoUrl = $request->getSchemeAndHttpHost() . '/storage/' . $cleanPath;

                    // Igual que en nosotros.blade.php: verificar ruta física y generar base64 seguro
                    $imagePath = storage_path('app/public/' . $cleanPath);
                    if (!file_exists($imagePath)) {
                        $publicStoragePath = public_path('storage/' . $cleanPath);
                        if (file_exists($publicStoragePath)) {
                            $imagePath = $publicStoragePath;
                        }
                    }

                    if (file_exists($imagePath) && is_readable($imagePath)) {
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $imageType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) ?: 'png';
                        if ($imageType === 'jpg') {
                            $imageType = 'jpeg';
                        }
                        $photoBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
                    }
                }

                return [
                    'id' => (int) $member->id,
                    'name' => (string) ($member->name ?? ''),
                    'last_name' => (string) ($member->last_name ?? ''),
                    'full_name' => trim(($member->name ?? '') . ' ' . ($member->last_name ?? '')),
                    'role' => (string) ($member->role ?? ''),
                    'order' => (int) ($member->order ?? 1),
                    'platform' => $member->platform,
                    'platform_link' => $member->platform_link,
                    'photo' => $photoUrl,
                    'photo_base64' => $photoBase64,
                ];
            })
        ]);
    }
}
