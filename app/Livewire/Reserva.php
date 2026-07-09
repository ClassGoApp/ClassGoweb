<?php

namespace App\Livewire;

use App\Models\PaymentSlotBooking;
use App\Models\SlotBooking;
use App\Models\User;
use App\Models\UserSubject;
use App\Services\ImagenesService;
use App\Services\interfaces\ICuponesService;
use App\Services\MailService;
use App\Services\PagosTutorReservaService;
use App\Services\SlotBookingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Reserva extends Component
{
    use WithFileUploads;

    public Carbon $currentDate;

    public ?int $selectedDay = null;

    // Para guardar la hora seleccionada
    // public ?string $selectedTime = null;
    public array $selectedTimes = [];

    // Datos de ejemplo que simulan la BBDD
    public array $daysWithAvailability = []; // Días con horas disponibles (para el círculo naranja)

    public array $timeSlotsByDay = [];     // Todas las horas (libres y ocupadas) por día

    public array $availableTimeSlots = []; // Horas que se muestran al seleccionar un día

    // Propiedades para el formulario del modal
    public $paymentReceipt;

    public $selectedSubject;

    public $showModal = false;

    public $reservaExitosa = false;

    // ============ Variables de Cupones ============//
    public $showModalCupones = false;

    public $cuponSelecionado = false;

    public $cupones = false;

    public $introCupon = true; // Opcion por defecto

    public $cuponCode = '';

    public $key = 1;

    public $cuponMensage = '';

    protected $validCupones = ['DESCUENTO10', 'OFERTA25', 'PROMO100']; // =======> SOLO DATOS DE PRUEBA!!!!!

    public $comprobante = true;

    public $banner100 = true;

    protected $cuponservice;

    public $cuponesUsuario = [];

    public float $porcentaje = 0.0;

    public float $precioTutor = 15.0;

    public float $montoFinal = 0.0;

    public float $descuento = 0.0;

    // ============== End Variables Cupones ===============//

    public bool $isAugustPromotion = false;
    public bool $isVirtual = false;
    public bool $showVirtualModal = false;
    public ?string $startTime = null;
    public int $duration = 20;
    public ?string $endTime = null;
    public ?string $timeRangeError = null;
    public array $tutorConfiguredRanges = [];

    // País detectado desde Cloudflare CF-IPCountry ('BO' = Bolivia, otro = internacional)
    public string $paisDetectado = 'XX';

    // Propiedades para el tutor
    public $tutorId;

    public $materiasTutor;

    public function mount(ICuponesService $cuponservice, $tutorId)
    {
        $this->tutorId = $tutorId;
        $this->currentDate = Carbon::now();
        $this->isAugustPromotion = $this->currentDate->month === 8; // ✅ Verificar si es agosto
        $this->cuponservice = $cuponservice;  // OK

        // Detectar país del visitante via Cloudflare (funciona en producción con CF activo)
        // En local: usar LOCAL_COUNTRY del .env para simular país (ej: LOCAL_COUNTRY=BO)
        // Si no existe ninguno de los dos, usar 'XX' (mostrará Takenos por defecto)
        $cfHeader = strtoupper(trim((string) request()->header('CF-IPCountry', '')));
        $envPais = strtoupper(trim((string) env('LOCAL_COUNTRY', '')));
        $pais = $cfHeader !== '' ? $cfHeader : ($envPais !== '' ? $envPais : 'XX');
        $this->paisDetectado = $pais;

        if (auth()->check()) {
            $this->cuponesUsuario = $this->cuponservice->todosLosCupones(auth()->user());
        } else {
            $this->cuponesUsuario = [];
            // Opcional: puedes redirigir o mostrar un mensaje
            // session()->flash('error', 'Debes iniciar sesión para ver tus cupones.');
        }

        $tutor = User::with('profile')->find($this->tutorId);
        $this->precioTutor = $tutor?->profile?->price ?? 15.0;

        // Calcular monto inicial
        $this->calcularMontoFinal();

        $this->loadMonthData();
        $this->materiasTutor = UserSubject::where('user_id', $this->tutorId)->get();
    }

    // ================== FUNCIONES DE CUPONES ====================//
    // public function calcularMontoFinal()
    // {
    //     $montoBase = $this->precioTutor;

    //     // Aplicar promoción de agosto si está activa
    //     if ($this->isAugustPromotion) {
    //         $this->montoFinal = 0.0;
    //         $this->descuento = $montoBase;
    //         return;
    //     }

    //     // Aplicar descuento de cupón si existe
    //     if ($this->porcentaje > 0) {
    //         $this->descuento = $montoBase * ($this->porcentaje / 100);
    //         $this->montoFinal = $montoBase - $this->descuento;
    //     } else {
    //         $this->montoFinal = $montoBase;
    //         $this->descuento = 0.0;
    //     }
    // }

    public function mostrarCupones()
    { // lista de cupones que se extraerá de la base de datos
        $this->cupones = true;
        $this->cuponMensage = '';
    }

    public function ocultarCupones()
    { // ocultar la lista
        $this->cupones = false;
    }

    public function cuponSeleccionado()
    { // Para mostrar el cupón selecionado cambiando la vista
        $this->cuponSelecionado = true;
        $this->introCupon = false;
    }

    public function quitarCupon()
    { // Para quitar el cupón seleccionado
        $this->introCupon = true;
        $this->cuponSelecionado = false;
        $this->comprobante = true;
        $this->cuponCode = '';
        $this->banner100 = true;
        $this->cuponMensage = '';
        $this->porcentaje = 0.0;

        $this->calcularMontoFinal();
    }

    public function ocultarComprobante()
    {
        $this->comprobante = false;
    }

    public function selecionarCupon($codigo)
    { // Selecionar el cupó

        $service = $this->cuponservice ?? app(ICuponesService::class);
        $this->cuponCode = $codigo;
        $this->cuponSeleccionado();
        $this->ocultarCupones();
        $this->key = now();
        // vmeter servicio de cupones
        $this->porcentaje = $service->porcentajeCupon($codigo);

        $this->calcularMontoFinal();

        if ($this->porcentaje == 100) { // Comprueba la tutoría Gratis
            $this->ocultarComprobante();
        } else {
            $this->ocultarBanner();
        }
    }

    public function ocultarBanner()
    {
        // Este código cambia el banner por un qr si es que el cupon no es de 100%
        $this->banner100 = false;
    }

    // Método para aplicar nuevo cupón Verificar de BD
    public function aplicarCupon()
    {
        $service = $this->cuponservice ?? app(ICuponesService::class);
        if ($service->existeCupon($this->cuponCode) && ! $service->verificaUsoCupon($this->cuponCode, auth()->user())) {
            $service->canjeaCupon($this->cuponCode, auth()->user());
            $this->cuponesUsuario = $service->todosLosCupones(auth()->user());
            $this->porcentaje = $service->porcentajeCupon($this->cuponCode);
            $this->calcularMontoFinal();
            $this->cuponSeleccionado();
            // Por el momento oculanto el comprobante, luego verificar si es el 100% el cupon introducido
            $this->ocultarComprobante();
        } else {
            $this->cuponMensage = 'Cupón Invalido';
        }
    }

    // ==================== END FUNCIONES DE CUPONES =======================//
    /**
     * Carga los datos de disponibilidad para el mes actual.
     * En un caso real, aquí harías una única consulta a tu BBDD para el mes visible.
     */
    public function loadMonthData()
    {
        $slotBookingService = app(SlotBookingService::class);
        $hoarioslibres = $slotBookingService->tiempoLibreTutor($this->tutorId);
        // Obtener el año y mes actual del calendario
        $currentYear = $this->currentDate->year;
        $currentMonth = $this->currentDate->month;
        // Procesar los datos reales de la BBDD
        $this->timeSlotsByDay = $this->processRealSlotData($hoarioslibres, $currentYear, $currentMonth);
        // Determina qué días tienen al menos una hora libre para marcarlos en naranja
        $this->daysWithAvailability = collect($this->timeSlotsByDay)
            ->filter(fn ($slots) => collect($slots)->where('status', 'free')->isNotEmpty())
            ->keys()
            ->toArray();
    }

    public function goToPreviousMonth()
    {
        $this->currentDate->subMonth();
        $this->resetSelection();
        $this->loadMonthData(); // Recarga los datos para el nuevo mes
    }

    public function goToNextMonth()
    {
        $this->currentDate->addMonth();
        $this->resetSelection();
        $this->loadMonthData(); // Recarga los datos para el nuevo mes
    }

    /**
     * Se ejecuta cuando el usuario hace clic en un día.
     */
    public function selectDay(int $day, string $month)
    {
        $fecha_actual = now();
        if ($this->isPastDay($day)) {
            return;
        }
        $this->selectedDay = $day;
        $this->selectedTimes = [];
        $this->startTime = null;
        $this->endTime = null;
        $this->duration = 20;
        $this->timeRangeError = null;

        if ($month == $fecha_actual->month && $day == $fecha_actual->day) {
            $slotsForToday = $this->timeSlotsByDay[$day] ?? [];
            $slotfiltrados = [];
            $horaActual = $fecha_actual->format('H:i');

            for ($i = 0; $i < count($slotsForToday); $i++) {
                if ($slotsForToday[$i]['time'] > $horaActual) {
                    $slotfiltrados[] = $slotsForToday[$i];
                }
            }
            $this->availableTimeSlots = $slotfiltrados;
        } else {
            $this->availableTimeSlots = $this->timeSlotsByDay[$day] ?? [];
        }

        // Determinar si es virtual o configurado
        $slots = $this->timeSlotsByDay[$day] ?? [];
        $hasConfigured = false;
        foreach ($slots as $s) {
            if (($s['slot_id'] ?? 0) > 0) {
                $hasConfigured = true;
                break;
            }
        }
        $this->isVirtual = !$hasConfigured;

        $this->tutorConfiguredRanges = [];
        if (!$this->isVirtual) {
            $slotIds = collect($slots)->pluck('slot_id')->unique()->filter()->toArray();
            if (!empty($slotIds)) {
                $realSlots = DB::table('user_subject_slots')->whereIn('id', $slotIds)->get();
                foreach ($realSlots as $rs) {
                    $this->tutorConfiguredRanges[] = [
                        'start' => Carbon::parse($rs->start_time)->format('H:i'),
                        'end' => Carbon::parse($rs->end_time)->format('H:i'),
                    ];
                }
            }
        }

        // Seleccionar hora por defecto
        if ($this->isVirtual) {
            if ($month == $fecha_actual->month && $day == $fecha_actual->day) {
                $nowTime = now()->addMinutes(10);
                if ($nowTime->format('H:i') < '07:00') {
                    $this->startTime = '07:00';
                } elseif ($nowTime->format('H:i') > '23:20') {
                    $this->startTime = '23:20';
                } else {
                    $this->startTime = $nowTime->format('H:i');
                }
            } else {
                $this->startTime = '07:00';
            }
        } else {
            if (!empty($this->tutorConfiguredRanges)) {
                $this->startTime = $this->tutorConfiguredRanges[0]['start'];
            }
        }

        $this->calculateAndValidate();
    }

    public function updatedStartTime($value)
    {
        $this->calculateAndValidate();
    }

    public function updatedDuration($value)
    {
        $this->calculateAndValidate();
    }

    public function calculateAndValidate()
    {
        $this->timeRangeError = null;
        $this->endTime = null;

        if (empty($this->startTime) || !$this->selectedDay) {
            return;
        }

        try {
            $start = Carbon::parse($this->startTime);
            $end = $start->copy()->addMinutes($this->duration);
            $this->endTime = $end->format('H:i');

            $fechaBase = $this->currentDate->copy()->setDay($this->selectedDay)->format('Y-m-d');
            $startDateTime = Carbon::parse($fechaBase . ' ' . $this->startTime . ':00');
            $endDateTime = Carbon::parse($fechaBase . ' ' . $this->endTime . ':00');

            // 1. Validar límites generales (07:00 a 23:40)
            $limitStart = Carbon::parse($fechaBase . ' 07:00:00');
            $limitEnd = Carbon::parse($fechaBase . ' 23:40:00');

            if ($startDateTime->lt($limitStart) || $endDateTime->gt($limitEnd)) {
                $this->timeRangeError = 'El horario seleccionado debe estar entre las 07:00 y las 23:40.';
                $this->resetCalculatedMonto();
                return;
            }

            // 2. Validar que no esté en el pasado
            if ($endDateTime->lte(now())) {
                $this->timeRangeError = 'No puedes seleccionar un horario en el pasado.';
                $this->resetCalculatedMonto();
                return;
            }

            // 3. Validar traslape con reservas existentes (status 1, 2, 7)
            $reservas = SlotBooking::where('tutor_id', $this->tutorId)
                ->whereIn('status', [1, 2, 7])
                ->where(function ($query) use ($startDateTime, $endDateTime) {
                    $query->where('start_time', '<', $endDateTime->toDateTimeString())
                          ->where('end_time', '>', $startDateTime->toDateTimeString());
                })
                ->exists();

            if ($reservas) {
                $this->timeRangeError = 'El horario seleccionado coincide con una reserva existente o pendiente.';
                $this->resetCalculatedMonto();
                return;
            }

            // 4. Validar caché / locks de otros estudiantes
            $cursor = $startDateTime->copy();
            while ($cursor->lt($endDateTime)) {
                $segStart = $cursor->format('H:i');
                $segEnd = $cursor->copy()->addMinutes(20)->format('H:i');
                $cacheKey = "booking_lock:{$this->tutorId}:{$fechaBase}:{$segStart}:{$segEnd}";

                if (Cache::has($cacheKey)) {
                    if (auth()->check() && Cache::get($cacheKey) != auth()->user()->id) {
                        $this->timeRangeError = 'Parte de este horario está bloqueado temporalmente por otro estudiante.';
                        $this->resetCalculatedMonto();
                        return;
                    } elseif (!auth()->check()) {
                        $this->timeRangeError = 'Parte de este horario está bloqueado temporalmente por otro estudiante.';
                        $this->resetCalculatedMonto();
                        return;
                    }
                }
                $cursor->addMinutes(20);
            }

            // 5. Validar disponibilidad del tutor si es un día configurado
            if (!$this->isVirtual) {
                $rangeCovered = false;
                foreach ($this->tutorConfiguredRanges as $r) {
                    $slotStart = Carbon::parse($fechaBase . ' ' . $r['start'] . ':00');
                    $slotEnd = Carbon::parse($fechaBase . ' ' . $r['end'] . ':00');

                    if ($startDateTime->greaterThanOrEqualTo($slotStart) && $endDateTime->lte($slotEnd)) {
                        $rangeCovered = true;
                        break;
                    }
                }

                if (!$rangeCovered) {
                    $this->timeRangeError = 'El horario seleccionado debe estar dentro de los rangos de disponibilidad del tutor.';
                    $this->resetCalculatedMonto();
                    return;
                }
            }

            // Si pasa todas las validaciones, calculamos el monto final
            $this->calcularMontoFinal();

        } catch (\Exception $e) {
            Log::error('Error validating range: ' . $e->getMessage());
            $this->timeRangeError = 'Error al procesar el horario seleccionado.';
            $this->resetCalculatedMonto();
        }
    }

    private function resetCalculatedMonto()
    {
        $this->montoFinal = 0.0;
        $this->descuento = 0.0;
    }

    /**
     * Se ejecuta cuando el usuario hace clic en una hora.
     */
    public function selectTime(string $time)
    {
        $slot = collect($this->availableTimeSlots)->firstWhere('time', $time);

        if ($slot && $slot['status'] === 'free') {
            // 1. Lógica para DESELECCIONAR (Toggle)
            if (in_array($time, $this->selectedTimes)) {
                // Al deseleccionar, para evitar huecos, lo ideal es resetear o
                // solo permitir deseleccionar los extremos. Por simplicidad, reseteamos:
                $this->selectedTimes = array_diff($this->selectedTimes, [$time]);
                $this->calcularMontoFinal();

                return;
            }

            // 2. Lógica para SELECCIONAR
            if (count($this->selectedTimes) >= 6) {
                session()->flash('error', 'Máximo 6 bloques.');

                return;
            }

            // --- RESTRICCIÓN DE CONTINUIDAD ---
            if (count($this->selectedTimes) > 0) {
                $esContinuo = $this->verificarContinuidad($time);

                if (! $esContinuo) {
                    session()->flash('error', 'Debes seleccionar bloques horarios consecutivos.');

                    return;
                }
            }

            // Si pasa las validaciones, agregamos
            $this->selectedTimes[] = $time;

            // Ordenamos las horas para que la lógica de continuidad siempre funcione
            sort($this->selectedTimes);

            $this->calcularMontoFinal();
        }
    }

    private function verificarContinuidad($newTime)
    {
        $newCarbon = Carbon::parse($newTime);
        $esValido = false;

        foreach ($this->selectedTimes as $selectedTime) {
            $selectedCarbon = Carbon::parse($selectedTime);

            // Calculamos la diferencia en minutos
            $diff = $selectedCarbon->diffInMinutes($newCarbon);

            // Si la diferencia es de exactamente 20 minutos, es consecutivo
            if ($diff == 20) {
                $esValido = true;
                break;
            }
        }

        return $esValido;
    }

    public function calcularMontoFinal()
    {
        // Si no hay nada seleccionado, el monto es el precio base (o 0, según prefieras)
        $cantidadBloques = (int) ($this->duration / 20) ?: 1;
        $montoBaseTotal = $this->precioTutor * $cantidadBloques;

        if ($this->isAugustPromotion) {
            $this->montoFinal = 0.0;
            $this->descuento = $montoBaseTotal;

            return;
        }

        if ($this->porcentaje > 0) {
            $this->descuento = $montoBaseTotal * ($this->porcentaje / 100);
            $this->montoFinal = $montoBaseTotal - $this->descuento;
        } else {
            $this->montoFinal = $montoBaseTotal;
            $this->descuento = 0.0;
        }
    }

    public function openReservationModal()
    {
        $this->calculateAndValidate();

        if ($this->timeRangeError) {
            session()->flash('error', $this->timeRangeError);
            return;
        }

        if (!$this->selectedDay || !$this->startTime || !$this->endTime) {
            session()->flash('error', 'Por favor, selecciona un día y un horario válido.');
            return;
        }

        // Generar selectedTimes dinámicamente en bloques de 20 minutos
        $start = Carbon::parse($this->startTime);
        $end = Carbon::parse($this->endTime);
        $cursor = $start->copy();
        
        $this->selectedTimes = [];
        while ($cursor->lt($end)) {
            $this->selectedTimes[] = $cursor->format('H:i');
            $cursor->addMinutes(20);
        }

        $estudianteId = auth()->user()->id;
        $fechaBase = $this->currentDate->copy()->setDay($this->selectedDay)->format('Y-m-d');

        // Si el slot es virtual, abrir el modal de solicitud simplificado
        if ($this->isVirtual) {
            $this->reservaExitosa = false;
            $this->showVirtualModal = true;
            return;
        }

        $lockedKeys = []; // Para revertir si falla alguno

        foreach ($this->selectedTimes as $hora) {
            $fechaVerificar = $this->currentDate->copy()
                ->setDay($this->selectedDay)
                ->setTimeFromTimeString($hora.':00')
                ->format('Y-m-d H:i:s');

            $horaCarbon = Carbon::parse($hora);
            $endFormatted = $horaCarbon->copy()->addMinutes(20)->format('H:i');

            // 1. Verificación de reserva activa del mismo estudiante
            $existe = SlotBooking::where('student_id', $estudianteId)
                ->where('start_time', '<=', $fechaVerificar)
                ->where('end_time', '>', $fechaVerificar)
                ->whereIn('status', [0, 1])
                ->exists();

            if ($existe) {
                $this->releaseLocks($lockedKeys);
                session()->flash('error', "Ya tienes una reserva activa el día {$this->selectedDay} a las {$hora}.");

                return;
            }

            // 2. Validar que el rango seleccionado siga libre en este preciso momento
            $ocupado = SlotBooking::where('tutor_id', $this->tutorId)
                ->where('start_time', '<=', $fechaVerificar)
                ->where('end_time', '>', $fechaVerificar)
                ->whereIn('status', [0, 1])
                ->exists();

            if ($ocupado) {
                $this->releaseLocks($lockedKeys);
                session()->flash('error', "El horario de las {$hora} ya no está disponible o fue tomado por otro estudiante en este momento. Por favor, selecciona otro.");
                $this->loadMonthData(); // Actualiza disponibilidad tras el error, como solicitado

                return;
            }

            // 3. Validar caché / Bloqueos temporales
            $cacheKey = "booking_lock:{$this->tutorId}:{$fechaBase}:{$hora}:{$endFormatted}";

            $added = Cache::add($cacheKey, $estudianteId, now()->addMinutes(15));
            if (! $added) {
                if (Cache::get($cacheKey) == $estudianteId) {
                    $lockedKeys[] = $cacheKey; // Ya lo teníamos bloqueado, seguimos
                } else {
                    $this->releaseLocks($lockedKeys);
                    session()->flash('error', "El horario de las {$hora} acaba de ser reservado temporalmente por otro estudiante. Por favor, selecciona otro.");
                    $this->loadMonthData();

                    return;
                }
            } else {
                $lockedKeys[] = $cacheKey;
            }
        }
        $this->reservaExitosa = false;
        $this->showModal = true;
    }

    public function closeVirtualModal()
    {
        $this->showVirtualModal = false;
        $this->reservaExitosa = false;
        $this->showModal = false;
    }

    /**
     * Crea la reserva virtual (pendiente de aceptación del tutor). No requiere pago.
     */
    public function makeVirtualRequest()
    {
        $this->validate(['selectedSubject' => 'required']);

        $estudianteId = auth()->user()->id;
        $fechaBase = $this->currentDate->copy()->setDay($this->selectedDay)->format('Y-m-d');

        $fechasParaReservar = [];
        foreach ($this->selectedTimes as $hora) {
            $fechasParaReservar[] = $this->currentDate->copy()
                ->setDay($this->selectedDay)
                ->setTimeFromTimeString($hora.':00')
                ->format('Y-m-d H:i:s');
        }

        try {
            DB::beginTransaction();

            $slotBookingService = app(SlotBookingService::class);
            $reserva = $slotBookingService->crearReservaContinua(
                $estudianteId,
                $this->tutorId,
                $this->selectedSubject,
                $fechasParaReservar,
                $this->montoFinal
            );

            DB::commit();

            $this->showVirtualModal = true;
            $this->reservaExitosa = true;

            $this->releaseCurrentLocks();
            $this->resetSelection();
            $this->loadMonthData();

            session()->flash('success_message', 'Solicitud enviada al tutor. Recibirás una notificación cuando sea aceptada.');

        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            Log::error('ERROR makeVirtualRequest', [
                'message' => $e->getMessage(),
                'student_id' => $estudianteId,
                'tutor_id' => $this->tutorId,
            ]);
            session()->flash('error', 'Hubo un error al enviar tu solicitud: '.$e->getMessage());
        }
    }

    private function releaseLocks($keys)
    {
        $estudianteId = auth()->check() ? auth()->user()->id : null;
        if (! $estudianteId) {
            return;
        }
        foreach ($keys as $key) {
            if (Cache::get($key) == $estudianteId) {
                Cache::forget($key);
            }
        }
    }

    private function releaseCurrentLocks()
    {
        if (auth()->check() && $this->selectedDay && ! empty($this->selectedTimes)) {
            $estudianteId = auth()->user()->id;
            $fechaBase = $this->currentDate->copy()->setDay($this->selectedDay)->format('Y-m-d');

            foreach ($this->selectedTimes as $hora) {
                $horaCarbon = Carbon::parse($hora);
                $endFormatted = $horaCarbon->copy()->addMinutes(20)->format('H:i');
                $cacheKey = "booking_lock:{$this->tutorId}:{$fechaBase}:{$hora}:{$endFormatted}";

                if (Cache::get($cacheKey) == $estudianteId) {
                    Cache::forget($cacheKey);
                }
            }
        }
    }

    /**
     * Se ejecuta automáticamente cuando cambia la materia seleccionada.
     * Limpia el estado de error rojo al instante.
     */
    public function updatedSelectedSubject()
    {
        $this->resetValidation('selectedSubject');
    }

    /**
     * Se ejecuta automáticamente cuando se empieza a subir el comprobante.
     * Limpia el estado de error rojo al instante.
     */
    public function updatedPaymentReceipt()
    {
        $this->resetValidation('paymentReceipt');
    }

    public function closeModal()
    {
        // Liberar bloqueos de caché al cancelar
        $this->releaseCurrentLocks();

        $this->showModal = false;

        $this->cuponCode = '';
        $this->cuponMensage = '';
        $this->porcentaje = 0.0;
        $this->introCupon = true;
        $this->cuponSelecionado = false;
        $this->comprobante = true;
        $this->banner100 = true;
        $this->cupones = false;

        // Recalcular el monto final (sin descuento)
        $this->calcularMontoFinal();

        // Resetear los campos del formulario
        $this->reset(['paymentReceipt', 'selectedSubject']);
    }

    /**
     * Finaliza la reserva. Se llama desde el formulario del modal.
     */
    public function makeReservation()
    {
        $sessionFee = $this->montoFinal;
        $service = $this->cuponservice ?? app(ICuponesService::class);
        $isAugustPromotion = $this->currentDate->month === 8;
        $fechasParaReservar = [];
        $reserva = null;
        $estudianteId = auth()->user()->id;

        Log::info('DEBUG makeReservation - inicio', [
            'student_id' => $estudianteId,
            'tutor_id' => $this->tutorId,
            'selectedSubject' => $this->selectedSubject,
            'selectedDay' => $this->selectedDay,
            'selectedTimes' => $this->selectedTimes,
            'selectedTimes_count' => count($this->selectedTimes),
            'montoFinal' => $this->montoFinal,
            'porcentaje' => $this->porcentaje,
            'cuponCode' => $this->cuponCode,
            'isAugustPromotion' => $isAugustPromotion,
        ]);

        if ($this->isVirtual || $isAugustPromotion || ! empty($this->cuponCode)) {
            if ($isAugustPromotion || ! empty($this->cuponCode)) {
                $sessionFee = 0;
            }
            $this->validate([
                'selectedSubject' => 'required',
            ]);
        } else {
            $this->validate([
                'paymentReceipt' => 'required|image|max:5120',
                'selectedSubject' => 'required',
            ]);
        }

        foreach ($this->selectedTimes as $hora) {
            $fechasParaReservar[] = $this->currentDate->copy()
                ->setDay($this->selectedDay)
                ->setTimeFromTimeString($hora.':00')
                ->format('Y-m-d H:i:s');
        }

        Log::info('DEBUG makeReservation - fechasParaReservar', [
            'fechas' => $fechasParaReservar,
            'count' => count($fechasParaReservar),
        ]);

        // Validación final de disponibilidad real del rango elegido
        foreach ($fechasParaReservar as $fechaStr) {
            $ocupado = SlotBooking::where('tutor_id', $this->tutorId)
                ->where('start_time', '<=', $fechaStr)
                ->where('end_time', '>', $fechaStr)
                ->whereIn('status', [0, 1])
                ->exists();

            if ($ocupado) {
                // Si alguien tomó el horario mientras estábamos en el modal
                session()->flash('error', 'El rango seleccionado ya no está disponible, fue tomado por otro estudiante. Por favor reserva otro horario.');
                $this->releaseCurrentLocks();
                $this->loadMonthData(); // Actualizar disponibilidad después del error
                $this->showModal = false; // Cerramos el modal para que pueda seleccionar nuevamente

                return;
            }
        }

        try {
            DB::beginTransaction();

            $pagostutorreserva = new PagosTutorReservaService;

            if ($this->porcentaje > 0) {
                $sessionFee = $sessionFee - ($sessionFee * $this->porcentaje / 100);
            }

            Log::info('DEBUG makeReservation - sessionFee calculado', [
                'sessionFee' => $sessionFee,
            ]);

            if (! empty($this->cuponCode)) {
                $service->cuponCanjeado($this->cuponCode, auth()->user());
                $this->cuponesUsuario = $service->todosLosCupones(auth()->user());

                Log::info('DEBUG makeReservation - cupon aplicado', [
                    'cuponCode' => $this->cuponCode,
                    'porcentaje' => $this->porcentaje,
                ]);
            }

            if ($this->isVirtual) {
                $path = null;
            } elseif ($this->porcentaje == 100 || $isAugustPromotion) {
                $path = 'qr/77b1a7da.jpg';
            } else {
                $imageService = app(ImagenesService::class);
                $path = $imageService->guardarqrEstudianteReserva($this->paymentReceipt);
            }

            Log::info('DEBUG makeReservation - path comprobante', [
                'path' => $path,
            ]);

            $slotBookingService = app(SlotBookingService::class);
            $reserva = $slotBookingService->crearReservaContinua(
                $estudianteId,
                $this->tutorId,
                $this->selectedSubject,
                $fechasParaReservar,
                $sessionFee
            );

            Log::info('DEBUG makeReservation - reserva creada', [
                'booking_id' => $reserva->id,
                'start_time' => $reserva->start_time,
                'end_time' => $reserva->end_time,
                'meeting_link' => $reserva->meeting_link,
            ]);

            PaymentSlotBooking::create([
                'slot_booking_id' => $reserva->id,
                'image_url' => $path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('DEBUG makeReservation - payment_slot_booking creado', [
                'slot_booking_id' => $reserva->id,
            ]);

            $pagostutorreserva->create(
                slot_booking_id: $reserva->id,
                payment_date: now(),
                amount: $sessionFee ?? 0,
                message: 'Reserva continua'
            );

            Log::info('DEBUG makeReservation - pago tutor creado', [
                'slot_booking_id' => $reserva->id,
                'amount' => 10,
            ]);

            DB::commit();

            Log::info('DEBUG makeReservation - commit OK', [
                'booking_id' => $reserva->id,
            ]);
        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            Log::error('ERROR makeReservation', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'student_id' => $estudianteId ?? null,
                'tutor_id' => $this->tutorId ?? null,
                'selectedSubject' => $this->selectedSubject ?? null,
                'selectedDay' => $this->selectedDay ?? null,
                'selectedTimes' => $this->selectedTimes ?? [],
                'selectedTimes_count' => is_array($this->selectedTimes ?? null) ? count($this->selectedTimes) : 0,
                'fechasParaReservar' => $fechasParaReservar ?? [],
                'sessionFee' => $sessionFee ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'Hubo un error al procesar tu reserva: '.$e->getMessage());

            return;
        }

        try {
            $tutor = User::find($this->tutorId);

            app(MailService::class)->sendAdminNuevaTutoria(
                $tutor?->profile?->full_name,
                $this->selectedSubject,
                $fechasParaReservar[0] ?? null
            );

            Log::info('DEBUG makeReservation - correo enviado', [
                'tutor_id' => $this->tutorId,
                'booking_id' => $reserva->id,
            ]);
        } catch (\Throwable $e) {
            Log::warning('WARNING makeReservation - la reserva se creó pero falló el correo', [
                'booking_id' => $reserva?->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }

        // $this->quitarCupon();
        // $this->showModal = false;

        // // Liberar bloqueos de caché (ya se guardó en DB con estado válido)
        // $this->releaseCurrentLocks();

        // $this->resetSelection();
        // $this->loadMonthData();

        // Log::info('DEBUG makeReservation - final OK', [
        //     'booking_id' => $reserva->id,
        // ]);

        // session()->flash('success_message', '¡Reserva realizada correctamente!');
        // // $this->dispatch('reload-page', section: 'reservas-tutor');
        // $this->dispatch('reserva-exitosa');

        $this->quitarCupon();

        $this->releaseCurrentLocks();

        $this->resetSelection();
        $this->loadMonthData();

        $this->reservaExitosa = true;

        session()->flash('success_message', 'Tutor reservado exitosamente.');

    }

    private function resetSelection()
    {
        $this->reset(['selectedDay', 'selectedTimes', 'availableTimeSlots', 'paymentReceipt']);
    }

    private function isPastDay(int $day): bool
    {
        return $this->currentDate->copy()->setDay($day)->isBefore(Carbon::today());
    }

    /**
     * Método auxiliar para procesar los datos reales de la BBDD
     * Genera slots de 20 minutos entre start_time y end_time para cada fecha
     */
    private function slotFallsInBookedRange(Carbon $slotDateTime, $reservas)
    {
        foreach ($reservas as $reserva) {
            $inicioReserva = Carbon::parse($reserva->start_time);
            $finReserva = Carbon::parse($reserva->end_time);

            if (
                $slotDateTime->greaterThanOrEqualTo($inicioReserva) &&
                $slotDateTime->lt($finReserva)
            ) {
                return true;
            }
        }

        return false;
    }

    private function processRealSlotData($tiempolibre, $year, $month)
    {
        $processedData = [];

        $monthStart = Carbon::create($year, $month, 1)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        // Traer reservas que se crucen con el mes visible
        $reservasDelMes = SlotBooking::where('tutor_id', $this->tutorId)
            ->where(function ($query) use ($monthStart, $monthEnd) {
                $query->whereBetween('start_time', [$monthStart, $monthEnd])
                    ->orWhereBetween('end_time', [$monthStart, $monthEnd])
                    ->orWhere(function ($q) use ($monthStart, $monthEnd) {
                        $q->where('start_time', '<', $monthStart)
                            ->where('end_time', '>', $monthEnd);
                    });
            })
            ->get();

        // Agrupar los slots reales configurados del tutor por día
        $slotsByDay = [];
        foreach ($tiempolibre as $slot) {
            $slotDate = Carbon::parse($slot->date)->startOfDay();
            if ($slotDate->year == $year && $slotDate->month == $month) {
                $slotsByDay[$slotDate->day][] = $slot;
            }
        }

        $daysInMonth = $monthStart->daysInMonth;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $targetDate = Carbon::create($year, $month, $day)->startOfDay();

            // No generar disponibilidad para días del pasado
            if ($targetDate->isBefore(Carbon::today())) {
                continue;
            }

            if (isset($slotsByDay[$day])) {
                // Si el tutor tiene horarios configurados para ese día, mostrar sus horarios normalmente
                foreach ($slotsByDay[$day] as $slot) {
                    $horaInicio = Carbon::parse($slot->start_time)->format('H:i:s');
                    $horaFin = Carbon::parse($slot->end_time)->format('H:i:s');

                    $startTime = $targetDate->copy()->setTimeFromTimeString($horaInicio);
                    $endTime = $targetDate->copy()->setTimeFromTimeString($horaFin);

                    $currentTime = $startTime->copy();

                    while ($currentTime->lessThan($endTime)) {
                        $timeString = $currentTime->format('H:i');
                        $isBooked = $this->slotFallsInBookedRange($currentTime, $reservasDelMes);

                        if (! $isBooked) {
                            $startFormatted = $timeString;
                            $endFormatted = $currentTime->copy()->addMinutes(20)->format('H:i');
                            $dateStr = $targetDate->format('Y-m-d');
                            $cacheKey = "booking_lock:{$this->tutorId}:{$dateStr}:{$startFormatted}:{$endFormatted}";

                            if (Cache::has($cacheKey)) {
                                if (auth()->check() && Cache::get($cacheKey) != auth()->user()->id) {
                                    $isBooked = true;
                                } elseif (! auth()->check()) {
                                    $isBooked = true;
                                }
                            }
                        }

                        $processedData[$day][] = [
                            'time' => $timeString,
                            'status' => $isBooked ? 'occupied' : 'free',
                            'slot_id' => $slot->id,
                        ];

                        $currentTime->addMinutes(20);
                    }
                }
            } else {
                // Si no tiene ningún horario disponible para ese día, mostrar bloques virtuales de 7am a 23:40pm
                $stepMinutes = 20;
                $rangeStart = Carbon::parse($targetDate->format('Y-m-d') . ' 07:00:00');
                $rangeEnd   = Carbon::parse($targetDate->format('Y-m-d') . ' 23:40:00');
                $cursor = $rangeStart->copy();

                while ($cursor->copy()->addMinutes($stepMinutes)->lte($rangeEnd)) {
                    $segStart = $cursor->copy();
                    $segEnd   = $cursor->copy()->addMinutes($stepMinutes);

                    // No mostrar horarios que ya pasaron
                    $now = now();
                    if ($segEnd->lte($now) || ($segStart->lte($now) && $segEnd->gt($now))) {
                        $cursor->addMinutes($stepMinutes);
                        continue;
                    }

                    $isBooked = $this->slotFallsInBookedRange($segStart, $reservasDelMes);

                    if (! $isBooked) {
                        $startFormatted = $segStart->format('H:i');
                        $endFormatted = $segEnd->format('H:i');
                        $dateStr = $targetDate->format('Y-m-d');
                        $cacheKey = "booking_lock:{$this->tutorId}:{$dateStr}:{$startFormatted}:{$endFormatted}";

                        if (Cache::has($cacheKey)) {
                            if (auth()->check() && Cache::get($cacheKey) != auth()->user()->id) {
                                    $isBooked = true;
                            } elseif (! auth()->check()) {
                                    $isBooked = true;
                            }
                        }
                    }

                    $processedData[$day][] = [
                        'time' => $segStart->format('H:i'),
                        'status' => $isBooked ? 'occupied' : 'free',
                        'slot_id' => 0, // 0 indica que es un slot virtual
                    ];

                    $cursor->addMinutes($stepMinutes);
                }
            }
        }

        return $processedData;
    }

    /**
     * Verifica si un slot específico está reservado
     * Aquí deberías consultar tu tabla de reservas/bookings
     */
    private function isTimeSlotBooked($tutorId, $dateTime)
    {
        return SlotBooking::where('tutor_id', $tutorId)
            ->where('start_time', '<=', $dateTime->format('Y-m-d H:i:s'))
            ->where('end_time', '>', $dateTime->format('Y-m-d H:i:s'))
            ->exists();
    }

    public function render()
    {
        // ... (lógica de renderizado sin cambios)
        $startDay = ($this->currentDate->copy()->startOfMonth()->dayOfWeekIso % 7);
        $daysInMonth = $this->currentDate->daysInMonth;

        return view('livewire.reserva', [
            'startDay' => $startDay,
            'daysInMonth' => $daysInMonth,
            'materiasTutor' => $this->materiasTutor,
            // Pasar el país detectado para que Alpine.js elija la pestaña inicial
            'paisDetectado' => $this->paisDetectado,
        ]);
    }
}
