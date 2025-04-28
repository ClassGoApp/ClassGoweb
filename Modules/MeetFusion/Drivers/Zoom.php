<?php

namespace Modules\MeetFusion\Drivers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\MeetFusion\Contracts\MeetFusionDriverInterface;
use GuzzleHttp\Client;

class Zoom implements MeetFusionDriverInterface
{

    protected string $accessToken;
    protected $client;
    protected $clientCredentials;

    public function setKeys($credentials)
    {
        $this->clientCredentials = $credentials;
    }

    protected function setupClient()
    {
        $this->accessToken = $this->getAccessToken();

        $this->client = new Client([
            'base_uri' => 'https://api.zoom.us/v2/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    protected function getAccessToken()
    {

        $client = new Client([
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->clientCredentials['client_id'] . ':' . $this->clientCredentials['client_secret']),
                'Host' => 'zoom.us',
            ],
        ]);

        $response = $client->request('POST', "https://zoom.us/oauth/token", [
            'form_params' => [
                'grant_type' => 'account_credentials',
                'account_id' => $this->clientCredentials['account_id'],
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody['access_token'];
    }

    /**
     * @params $params
     *       [
     *        'host_email',
     *        'topic',
     *        'agenda',       
     *        'duration',       
     *        'timezone',       
     *        'start_time',       
     *        'schedule_for'
     *     ]       
     */

    // create meeting
    public function createMeeting(array $data)
    {
        Log::info("�0�8 Iniciando la creaci��n de la reuni��n en Zoom.", ['data' => $data]);

        try {
            // Configuraci��n del cliente Zoom
            Log::info("�9�3 Configurando cliente Zoom...");
            $this->setupClient();
            Log::info("�7�3 Cliente Zoom configurado correctamente.");

            // Enviando solicitud a Zoom API
            Log::info("�9�3 Enviando solicitud a Zoom API...");
            $response = $this->client->request('POST', 'users/me/meetings', [
                'json' => $this->getMeetingData($data),
            ]);

            // Respuesta de Zoom
            Log::info("�7�3 Respuesta recibida de Zoom API.");
            $res = json_decode($response->getBody(), true);
            Log::info("�9�0 Datos recibidos de Zoom:", ['response' => $res]);

            // Obtener el Meeting ID
            $meetingId = $res['id'] ?? null;
            if (!$meetingId) {
                Log::error("�7�4 No se pudo obtener el Meeting ID de la respuesta de Zoom.");
                return [
                    'status' => false,
                    'message' => 'No se pudo crear la reuni��n en Zoom.',
                ];
            }

            Log::info("�7�3 Meeting ID obtenido.", ['meeting_id' => $meetingId]);

            // Calcular el tiempo de finalizaci��n (5 minutos despu��s del inicio)
            $startTime = isset($res['start_time']) ? Carbon::parse($res['start_time'])->addMinutes(5) : null;
            Log::info("�7�7 Tiempo de finalizaci��n calculado.", ['start_time' => $startTime]);


            return [
                'status' => true,
                'data' => [
                    'link' => $res['join_url'] ?? '',
                    'meeting_id' => $meetingId,
                    'start_time' => $res['start_time'] ?? '',
                    'password' => $res['password'] ?? '',
                ],
            ];
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            $errorResponse = $ex->getResponse() ? $ex->getResponse()->getBody()->getContents() : 'No response';
            Log::error("�7�4 Error en la solicitud a Zoom API.", ['error' => $errorResponse]);

            return [
                'status' => false,
                'message' => $errorResponse,
            ];
        } catch (\Exception $ex) {
            Log::error("�7�4 Error inesperado al crear la reuni��n en Zoom.", ['error' => $ex->getMessage()]);

            return [
                'status' => false,
                'message' => $ex->getMessage(),
            ];
        }
    }

    protected function getMeetingData($params) {
        Log::info("�9�8 Generando datos para la reuni��n.", ['params' => $params]);
    
        $meetingData = [
            "topic"         => $params['topic'] ?? "Reuni��n de Zoom",
            "agenda"        => $params['agenda'] ?? "",
            "type"          => 2, // 1 => instant��nea, 2 => programada, 3 => recurrente sin horario, 8 => recurrente con horario
            "start_time"    => $params['start_time'] ?? now()->toIso8601String(),
            "timezone"      => $params['timezone'] ?? "UTC",
            "duration"      => 5, // Duraci��n en minutos
            "password"      => generatePassword(),
            "settings"      => [
                "waiting_room"      => false,  // Desactiva la sala de espera
                "join_before_host"  => true,  // No permite que los participantes ingresen antes del host
                "approval_type"     => 0,     // Aprobaci��n autom��tica de los participantes
                "mute_upon_entry"   => true,  // Silencia a los participantes al entrar
                "auto_recording"    => "none" // No graba autom��ticamente la sesi��n
            ]
        ];
    
        Log::info("�7�3 Datos de reuni��n generados correctamente.", ['meeting_data' => $meetingData]);
    
        return $meetingData;
    }
    

}
