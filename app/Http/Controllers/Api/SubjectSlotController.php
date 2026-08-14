<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSubjectSlot;
use Illuminate\Support\Facades\Validator;
use App\Services\SlotBookingService;
use Carbon\Carbon;
use App\Models\SlotBooking;

class SubjectSlotController extends Controller
{   
    public array $timeSlotsByDay = []; 
    public array $daysWithAvailability = [];
    public function getUserSubjectSlots(Request $request)
    {
        // Obtener `user_id` y fechas de la solicitud
        $userId = $request->input('user_id');
        $date = $request->only(['start_date', 'end_date']);

        // Validar que se haya enviado el user_id
        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        // Obtener los horarios filtrados por usuario
        $slotsData = $this->fetchUserSubjectSlots($userId, $date);

        return response()->json($slotsData);
    }

    public function getTutorAvailableSlots($id, Request $request)
    {
        $date = $request->only(['start_date', 'end_date']);
        $slotsData = $this->fetchUserSubjectSlots($id, $date);
        return response()->json($slotsData);
    }

    /**
     * Crear un nuevo slot de disponibilidad para un tutor
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUserSubjectSlot(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'date' => 'required|date|after_or_equal:today',
            'duracion' => 'nullable', // Acepta cualquier tipo
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validar solapamiento con horarios existentes (misma fecha y usuario)
        $overlap = UserSubjectSlot::where('user_id', $request->user_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($overlap) {
            return response()->json([
                'success' => false,
                'message' => "Ya tienes un horario existente que se solapa en la fecha {$request->date}"
            ], 422);
        }

        try {
            // Calcular duración automáticamente si no se proporciona
            $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
            $endTime = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
            
            // Procesar la duración
            if ($request->duracion) {
                // Si es un número, convertirlo a string con "minutos"
                if (is_numeric($request->duracion)) {
                    $duracion = $request->duracion . ' minutos';
                } else {
                    $duracion = $request->duracion;
                }
            } else {
                // Calcular automáticamente
                $duracion = $startTime->diffInMinutes($endTime) . ' minutos';
            }

            // Crear el slot con solo las columnas que existen
            $slot = UserSubjectSlot::create([
                'user_id' => $request->user_id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date,
                'duracion' => $duracion,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Slot de disponibilidad creado exitosamente',
                'data' => $slot
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el slot de disponibilidad',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un slot de disponibilidad de un tutor
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserSubjectSlot(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'slot_id' => 'required|exists:user_subject_slots,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buscar el slot y verificar que pertenece al usuario
            $slot = UserSubjectSlot::where('id', $request->slot_id)
                ->where('user_id', $request->user_id)
                ->first();

            if (!$slot) {
                return response()->json([
                    'success' => false,
                    'message' => 'Slot no encontrado o no tienes permisos para eliminarlo'
                ], 404);
            }

            // Verificar si el slot tiene reservas
            if ($slot->bookings()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el slot porque tiene reservas activas'
                ], 400);
            }

            // Eliminar el slot
            $slot->delete();

            return response()->json([
                'success' => true,
                'message' => 'Slot de disponibilidad eliminado exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el slot de disponibilidad',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function fetchUserSubjectSlots($userId, $date = null) {
        $slots = UserSubjectSlot::select('id','start_time','end_time','duracion','date','user_id')
            ->withCount('bookings')
            ->with('students', fn($query) => $query->select('profiles.id','profiles.user_id', 'profiles.image')->limit(5))
            ->when($date, function ($slots) use ($date) {
                $slots->where('start_time', '>=', $date['start_date']);
                $slots->where('end_time', '<=', $date['end_date']);
            })
            ->where('user_id', $userId)
            ->orderBy('start_time')
            ->get();

        return $slots;
    }

    public function getStlotTutorForDate($tutorId, Request $request) {
        $slotBookingService = app(SlotBookingService::class);
        $hoarioslibres = $slotBookingService->tiempoLibreTutor($tutorId);
        // Obtener el año y mes actuales para filtrar los slots
        $currentYear = $request->year ?? Carbon::now()->year;
        $currentMonth = $request->month ?? Carbon::now()->month;

        // Procesar los datos reales de la BBDD
        $this->timeSlotsByDay = $this->processRealSlotData($hoarioslibres, $currentYear, $currentMonth, $tutorId);
        // Determina qué días tienen al menos una hora libre para marcarlos en naranja
        $this->daysWithAvailability = collect($this->timeSlotsByDay)
            ->filter(fn($slots) => collect($slots)->where('status', 'free')->isNotEmpty())
            ->keys()
            ->toArray();
        return response()->json([
            'Date'=>$this->timeSlotsByDay
        ]);
    }
    /**
     * Método auxiliar para procesar los datos reales de la BBDD
     * Genera slots de 20 minutos entre start_time y end_time para cada fecha
     */
    private function processRealSlotData($tiempolibre, $year, $month, $tutorId)
    {
        $processedData = [];      // Array final que se retorna
        $totalProcesados = 0;     // Contador para debug

        // ===== PASO 1: OPTIMIZACIÓN DE CONSULTAS =====
        // En lugar de consultar la BD por cada slot de 20 minutos,
        // obtenemos TODAS las reservas del mes de una sola vez
        $reservasDelMes = SlotBooking::where('tutor_id', $tutorId)
            ->whereYear('start_time', $year)    // Filtra por año
            ->whereMonth('start_time', $month)  // Filtra por mes
            ->get()
            ->keyBy(function ($reserva) {
                // Crea un índice usando la fecha/hora como clave
                // Ejemplo: "2025-08-14 08:20:00" => objeto_reserva
                return Carbon::parse($reserva->start_time)->format('Y-m-d H:i:s');
            });

        // ===== PASO 2: PROCESAR CADA HORARIO DISPONIBLE DEL TUTOR =====
        foreach ($tiempolibre as $slot) {

            // --- 2.1: Extraer fecha del slot ---
            // $slot->date contiene algo como "2025-08-14 00:00:00"
            // startOfDay() asegura que sea medianoche: "2025-08-14 00:00:00"
            $slotDate = Carbon::parse($slot->date)->startOfDay();

            // --- 2.2: Verificar si el slot pertenece al mes actual ---
            // Solo procesa slots que coincidan con el año/mes del calendario
            if ($slotDate->year == $year && $slotDate->month == $month) {

                // --- 2.3: Determinar el día del mes ---
                $day = $slotDate->day; // Ej: 14 (para el 14 de agosto)

                // --- 2.4: Inicializar array para este día si no existe ---
                if (!isset($processedData[$day])) {
                    $processedData[$day] = [];
                }

                // --- 2.5: Construir horarios de inicio y fin ---
                // $slot->start_time puede ser "06:00:00" o una fecha completa
                // setTimeFromTimeString() toma solo la parte de hora
                $horaInicio = Carbon::parse($slot->start_time)->format('H:i:s');
                $horaFin = Carbon::parse($slot->end_time)->format('H:i:s');

                $startTime = $slotDate->copy()->setTimeFromTimeString($horaInicio);
                $endTime = $slotDate->copy()->setTimeFromTimeString($horaFin);

                // Ejemplo:
                // $startTime = "2025-08-14 06:00:00"
                // $endTime   = "2025-08-14 13:00:00"

                // --- 2.6: Inicializar tiempo actual para el bucle ---
                $currentTime = $startTime->copy();

                // ===== PASO 3: GENERAR SLOTS DE 20 MINUTOS =====
                // Divide el horario disponible en slots de 20 minutos
                while ($currentTime->lessThan($endTime)) {

                    // --- 3.1: Formatear hora para mostrar ---
                    $timeString = $currentTime->format('H:i'); // Ej: "08:20"

                    // --- 3.2: Crear clave para buscar en reservas ---
                    $datetimeKey = $currentTime->format('Y-m-d H:i:s');
                    // Ej: "2025-08-14 08:20:00"

                    // --- 3.3: VERIFICAR SI ESTÁ OCUPADO ---
                    // Busca en el array de reservas si existe esta fecha/hora exacta
                    // has() es mucho más rápido que consultar la BD cada vez
                    $isBooked = $reservasDelMes->has($datetimeKey);

                    $totalProcesados++; // Contador para debug

                    // --- 3.4: AGREGAR SLOT AL RESULTADO ---
                    $processedData[$day][] = [
                        'time' => $timeString,                           // "08:20"
                        'status' => $isBooked ? 'occupied' : 'free',     // Estado del slot
                        'slot_id' => $slot->id                           // ID del horario base
                    ];

                    // --- 3.5: AVANZAR 20 MINUTOS ---
                    // Pasa al siguiente slot de tiempo
                    $currentTime->addMinutes(20);
                    // Siguiente iteración: "08:40", luego "09:00", etc.
                }

                // Al terminar el while, este slot está completamente procesado
                // Continúa con el siguiente slot del foreach
            }

            // Si el slot no pertenece al mes actual, se omite completamente
        }

        // ]
        return $processedData;
    }
}
