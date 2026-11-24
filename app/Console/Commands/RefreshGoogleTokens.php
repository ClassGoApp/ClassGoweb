<?php

namespace App\Console\Commands;

use App\Models\AccountSetting;
use App\Models\User;
use App\Services\GoogleMeetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RefreshGoogleTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:refresh-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresca periódicamente los tokens de Google Calendar de tutores para evitar caducidad por inactividad y detectar tokens revocados.';

    /**
     * Execute the console command.
     */
    public function handle(GoogleMeetService $googleMeetService): int
    {
        $userIds = AccountSetting::where('meta_key', 'google_access_token')
            ->whereNotNull('meta_value')
            ->pluck('user_id')
            ->unique();

        $refreshed = 0;
        $needsReconnect = 0;
        $transientErrors = 0;

        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if (!$user) {
                continue;
            }

            try {
                $googleMeetService->getAuthenticatedClientForUser($user, true);
                $refreshed++;
            } catch (\Throwable $e) {
                if (str_contains($e->getMessage(), 'invalid_grant')) {
                    $needsReconnect++;
                    Log::warning('Google Calendar token revocado/caducado (invalid_grant)', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                    ]);
                } else {
                    $transientErrors++;
                    Log::warning('Error temporal al refrescar token de Google Calendar', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        $summary = "Google tokens: {$refreshed} refrescados, {$needsReconnect} requieren reconexión (invalid_grant), {$transientErrors} errores temporales.";
        $this->info($summary);
        Log::info($summary);

        return self::SUCCESS;
    }
}
