<?php


namespace App\Livewire;

use App\Models\PaymentSlotBooking;
use App\Models\SlotBooking;
use App\Models\Subject;
use App\Models\User;
use App\Models\UserSubject;
use App\Services\CuponesService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\SlotBookingService;
use App\Services\ImagenesService;
use App\Services\interfaces\ICuponesService;
use App\Services\PagosTutorReservaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\MailService;
use Illuminate\Support\Facades\Auth;


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

    // ============ Variables de Cupones ============//
    public $showModalCupones = false;
    public $cuponSelecionado = false;

    public $cupones = false;
    public $introCupon = true; //Opcion por defecto
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


    //============== End Variables Cupones ===============//

    public bool $isAugustPromotion = false;

    // Propiedades para el tutor
    public $tutorId;
    public $materiasTutor;

    public function mount(ICuponesService $cuponservice, $tutorId)
    {
        $this->tutorId = $tutorId;
        $this->currentDate = Carbon::now();
        $this->isAugustPromotion = $this->currentDate->month === 8; // ✅ Verificar si es agosto
        $this->cuponservice = $cuponservice;  // OK

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
        $this->materiasTutor = UserSubject::where("user_id", $this->tutorId)->get();
    }

    //================== FUNCIONES DE CUPONES ====================//
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
    { //lista de cupones que se extraerá de la base de datos
        $this->cupones = true;
        $this->cuponMensage = '';
    }
    public function ocultarCupones()
    { //ocultar la lista
        $this->cupones = false;
    }
    public function cuponSeleccionado()
    { //Para mostrar el cupón selecionado cambiando la vista
        $this->cuponSelecionado = true;
        $this->introCupon = false;
    }

    public function quitarCupon()
    { //Para quitar el cupón seleccionado
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
    { //Selecionar el cupó

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
        //Este código cambia el banner por un qr si es que el cupon no es de 100%
        $this->banner100 = false;
    }

    //Método para aplicar nuevo cupón Verificar de BD
    public function aplicarCupon()
    {
        $service = $this->cuponservice ?? app(ICuponesService::class);
        if ($service->existeCupon($this->cuponCode) && !$service->verificaUsoCupon($this->cuponCode, auth()->user())) {
            $service->canjeaCupon($this->cuponCode, auth()->user());
            $this->cuponesUsuario = $service->todosLosCupones(auth()->user());
            $this->porcentaje = $service->porcentajeCupon($this->cuponCode);
            $this->calcularMontoFinal();
            $this->cuponSeleccionado();
            //Por el momento oculanto el comprobante, luego verificar si es el 100% el cupon introducido
            $this->ocultarComprobante();
        } else {
            $this->cuponMensage = 'Cupón Invalido';
        }
    }
    //==================== END FUNCIONES DE CUPONES =======================//
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
            ->filter(fn($slots) => collect($slots)->where('status', 'free')->isNotEmpty())
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
        if ($this->isPastDay($day))
            return;
        $this->selectedDay = $day;
        $this->selectedTimes = []; // Resetea la hora al cambiar de día



        if ($month == $fecha_actual->month && $day == $fecha_actual->day) {
            $slotsForToday = $this->timeSlotsByDay[$day] ?? [];
            //dd($slotsForToday);
            $slotfiltrados = [];
            $horaActual = $fecha_actual->format('H:i');


            //dd($horaActual); 
            for ($i = 0; $i < count($slotsForToday); $i++) {

                if ($slotsForToday[$i]['time'] > $horaActual) {

                    $slotfiltrados[] = $slotsForToday[$i];
                }
            }
            //dd($slotfiltrados);
            $this->availableTimeSlots = $slotfiltrados;
        } else {
            $this->availableTimeSlots = $this->timeSlotsByDay[$day] ?? [];
        }

        //$this->availableTimeSlots = $this->timeSlotsByDay[$day] ?? [];
    }

    /**
     * Se ejecuta cuando el usuario hace clic en una hora.
     */
    // public function selectTime(string $time)
    // {
    //     // Busca el slot para asegurarse de que está libre
    //     $slot = collect($this->availableTimeSlots)->firstWhere('time', $time);

    //     if ($slot && $slot['status'] === 'free') {
    //         $this->selectedTime = $time;
    //     }
    // }

    // public function selectTime(string $time)
    // {
    //     // 1. Buscamos si el slot está libre en los datos cargados
    //     $slot = collect($this->availableTimeSlots)->firstWhere('time', $time);

    //     if ($slot && $slot['status'] === 'free') {
    //         // 2. Si ya está seleccionado, lo quitamos (Toggle)
    //         if (in_array($time, $this->selectedTimes)) {
    //             $this->selectedTimes = array_diff($this->selectedTimes, [$time]);
    //         } else {
    //             // 3. Si no está, verificamos el límite de 6
    //             if (count($this->selectedTimes) < 6) {
    //                 $this->selectedTimes[] = $time;
    //             } else {
    //                 session()->flash('error', 'Solo puedes seleccionar un máximo de 6 horarios.');
    //             }
    //         }
    //     }
    // }

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

                if (!$esContinuo) {
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
        $cantidadBloques = count($this->selectedTimes) ?: 1;
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

    // public function openReservationModal()
    // {
    //     // Opcional: Puedes añadir una validación aquí para asegurarte
    //     // de que el usuario ya ha seleccionado un día y una hora.
    //     if (!$this->selectedDay || empty($this->selectedTimes)) {
    //         session()->flash('error', 'Por favor, selecciona un día y una hora antes de continuar.');
    //         return;
    //     }
    //     $estudianteId = auth()->user()->id;
    //     $fechaCompleta = $this->currentDate->copy()
    //         ->setDay($this->selectedDay)
    //         ->setTimeFromTimeString($this->selectedTime . ':00');
    //     $tienereserva = SlotBooking::where('student_id', $estudianteId)->get();

    //     for ($i = 0; $i < count($tienereserva); $i++) {
    //         if ($tienereserva[$i]->start_time === $fechaCompleta->format('Y-m-d H:i:s')) {
    //             session()->flash('error', 'Ya tienes una reserva activa en este horario. Por favor, completa  esa reserva antes de hacer una nueva.');
    //             return;
    //         }
    //     }
    //     $this->showModal = true;
    //     // Emite un evento global que el JavaScript del frontend escuchará.
    //     //$this->dispatch('open-modal');
    // }

    public function openReservationModal()
    {
        // 1. Validar que haya selección
        if (!$this->selectedDay || empty($this->selectedTimes)) {
            session()->flash('error', 'Por favor, selecciona un día y al menos una hora.');
            return;
        }

        $estudianteId = auth()->user()->id;

        // 2. Verificar cada hora seleccionada contra la BD
        foreach ($this->selectedTimes as $hora) {
            $fechaVerificar = $this->currentDate->copy()
                ->setDay($this->selectedDay)
                ->setTimeFromTimeString($hora . ':00')
                ->format('Y-m-d H:i:s');

            $existe = SlotBooking::where('student_id', $estudianteId)
                ->where('start_time', $fechaVerificar)
                ->exists();

            if ($existe) {
                session()->flash('error', "Ya tienes una reserva activa el día {$this->selectedDay} a las {$hora}.");
                return;
            }
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
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
    // public function makeReservation()
    // {


    //     $sessionFee = $this->montoFinal;
    //     $service = $this->cuponservice ?? app(ICuponesService::class);
    //     $isAugustPromotion = $this->currentDate->month === 9;

    //     if ($isAugustPromotion || (!empty($this->cuponCode))) {
    //         $sessionFee = 0;
    //         $this->validate([
    //             'selectedSubject' => 'required',
    //         ]);
    //     } else {
    //         $this->validate([
    //             'paymentReceipt' => 'required|image|max:5120',
    //             'selectedSubject' => 'required',
    //         ]);
    //     }
    //     try {
    //         DB::beginTransaction();
    //         $pagostutorreserva = new PagosTutorReservaService();

    //         if ($this->porcentaje != null || $this->porcentaje != 0) {
    //             $sessionFee = $sessionFee - ($sessionFee * $this->porcentaje / 100);
    //         }
    //         $estudianteId = auth()->user()->id;
    //         // 2.1. registra que ya se uso el cupon en esta session
    //         if (!empty($this->cuponCode)) {
    //             $service->cuponCanjeado($this->cuponCode, auth()->user());
    //             $this->cuponesUsuario = $service->todosLosCupones(auth()->user());
    //         }

    //         $fechaCompleta = $this->currentDate->copy()
    //             ->setDay($this->selectedDay)
    //             ->setTimeFromTimeString($this->selectedTime . ':00');
    //         $fechaString = $fechaCompleta->format('Y-m-d H:i:s');

    //         if ($this->porcentaje == 100 || $isAugustPromotion) {
    //             // Usar imagen por defecto para promoción
    //             $path = 'qr/77b1a7da.jpg'; // Imagen por defecto
    //         } else {
    //             // Guardar imagen del usuario
    //             $imageService = app(ImagenesService::class);
    //             $path = $imageService->guardarqrEstudianteReserva($this->paymentReceipt);
    //         }
    //         // 2. Crear reserva
    //         $slotBookingService = app(SlotBookingService::class);
    //         // $reserva = $slotBookingService->crearReserva(
    //         //     $estudianteId,
    //         //     $this->tutorId,
    //         //     $this->selectedSubject,
    //         //     $fechaString,
    //         //     $sessionFee
    //         // );


    //         // 3. Crear registro de pago
    //         PaymentSlotBooking::create([
    //             'slot_booking_id' => $reserva->id,
    //             'image_url' => $path,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);
    //         // 4. Crear registro de pago del tutor
    //         $pagostutorreserva->create(
    //             slot_booking_id: $reserva->id,
    //             payment_date: now(),
    //             amount: 10,
    //             message: ''
    //         );

    //         DB::commit();
    //         $tutor = User::where('id', $this->tutorId)->first();
    //         $emailService = app(MailService::class);
    //         $emailService->sendAdminNuevaTutoria(
    //             $tutor?->profile?->full_name,
    //             $this->selectedSubject,
    //             $fechaString
    //         );

    //         // Resetear estado y mostrar éxito
    //         $this->quitarCupon();
    //         $this->showModal = false;
    //         $this->resetSelection();




    //         $this->loadMonthData();
    //         session()->flash('success_message', '¡Hora reservada correctamente!');
    //         $this->dispatch('reload-page', section: 'reservas-tutor');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error creando reserva', [
    //             'error' => $e->getMessage(),
    //             'tutor_id' => $this->tutorId,
    //             'student_id' => $estudianteId,
    //             'fecha' => $fechaString ?? null
    //         ]);
    //         session()->flash('error', 'Hubo un error al procesar tu reserva. Por favor, inténtalo de nuevo.');
    //     }
    // }


    public function makeReservation()
    {
        $sessionFee = $this->montoFinal;
        $service = $this->cuponservice ?? app(ICuponesService::class);
        $isAugustPromotion = $this->currentDate->month === 9;

        // 1. Validaciones
        if ($isAugustPromotion || (!empty($this->cuponCode))) {
            $sessionFee = 0;
            $this->validate(['selectedSubject' => 'required']);
        } else {
            $this->validate([
                'paymentReceipt' => 'required|image|max:5120',
                'selectedSubject' => 'required',
            ]);
        }

        try {
            DB::beginTransaction();
            $pagostutorreserva = new PagosTutorReservaService();

            if ($this->porcentaje > 0) {
                $sessionFee = $sessionFee - ($sessionFee * $this->porcentaje / 100);
            }

            $estudianteId = auth()->user()->id;

            if (!empty($this->cuponCode)) {
                $service->cuponCanjeado($this->cuponCode, auth()->user());
                $this->cuponesUsuario = $service->todosLosCupones(auth()->user());
            }

            // --- SOLUCIÓN AL ERROR: Crear la variable $fechasParaReservar ---
            $fechasParaReservar = [];
            foreach ($this->selectedTimes as $hora) {
                $fechasParaReservar[] = $this->currentDate->copy()
                    ->setDay($this->selectedDay)
                    ->setTimeFromTimeString($hora . ':00')
                    ->format('Y-m-d H:i:s');
            }

            if ($this->porcentaje == 100 || $isAugustPromotion) {
                $path = 'qr/77b1a7da.jpg';
            } else {
                $imageService = app(ImagenesService::class);
                $path = $imageService->guardarqrEstudianteReserva($this->paymentReceipt);
            }

            // 2. Llamar al nuevo método del servicio
            $slotBookingService = app(SlotBookingService::class);
            $reservas = $slotBookingService->crearReservasMultiples(
                $estudianteId,
                $this->tutorId,
                $this->selectedSubject,
                $fechasParaReservar, // <--- Ahora la variable sí existe
                $sessionFee
            );

            // 3. Registro de pago (Usamos la primera reserva del grupo para el recibo)
            PaymentSlotBooking::create([
                'slot_booking_id' => $reservas[0]->id, // <--- Cambiado de $reserva a $reservas[0]
                'image_url' => $path,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 4. Pago al tutor (puedes ajustar el monto de 10 si es variable)
            $pagostutorreserva->create(
                slot_booking_id: $reservas[0]->id,
                payment_date: now(),
                amount: 10,
                message: 'Reserva múltiple'
            );

            DB::commit();

            // Enviar Email (Usamos la fecha de la primera clase para el correo)
            $tutor = User::find($this->tutorId);
            app(MailService::class)->sendAdminNuevaTutoria(
                $tutor?->profile?->full_name,
                $this->selectedSubject,
                $fechasParaReservar[0]
            );

            $this->quitarCupon();
            $this->showModal = false;
            $this->resetSelection();
            $this->loadMonthData();

            session()->flash('success_message', '¡Reservas realizadas correctamente!');
            $this->dispatch('reload-page', section: 'reservas-tutor');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en reserva múltiple: ' . $e->getMessage());
            session()->flash('error', 'Hubo un error al procesar tu reserva.');
        }
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
    private function processRealSlotData($tiempolibre, $year, $month)
    {
        $processedData = [];      // Array final que se retorna
        $totalProcesados = 0;     // Contador para debug

        // ===== PASO 1: OPTIMIZACIÓN DE CONSULTAS =====
        // En lugar de consultar la BD por cada slot de 20 minutos,
        // obtenemos TODAS las reservas del mes de una sola vez
        $reservasDelMes = SlotBooking::where('tutor_id', $this->tutorId)
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






    /**
     * Verifica si un slot específico está reservado
     * Aquí deberías consultar tu tabla de reservas/bookings
     */
    private function isTimeSlotBooked($tutorId, $dateTime)
    {


        $ocupados = SlotBooking::where('tutor_id', $tutorId)
            //->where('date', $dateTime->format('Y-m-d'))
            ->where('start_time', $dateTime->format('Y-m-d H:i:s'))
            ->exists();

        //dd($ocupados);  
        return $ocupados;
    }

    public function render()
    {
        // ... (lógica de renderizado sin cambios)
        $startDay = ($this->currentDate->copy()->startOfMonth()->dayOfWeekIso % 7);
        $daysInMonth = $this->currentDate->daysInMonth;

        return view('livewire.reserva', [
            'startDay' => $startDay,
            'daysInMonth' => $daysInMonth,
            'materiasTutor' => $this->materiasTutor
        ]);
    }
}
