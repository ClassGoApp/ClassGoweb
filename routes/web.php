<?php

use App\Http\Controllers\Admin\TutorController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ConferencesController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\GoogleController;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstantTutoringController;
use App\Http\Controllers\PromocionesController;
use App\Http\Controllers\Impersonate;
use App\Http\Controllers\OpenAiController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ExportImageController;
use App\Livewire\Frontend\BlogDetails;
use App\Livewire\Frontend\Blogs;
use App\Livewire\Frontend\Checkout;
use App\Livewire\Frontend\ThankYou;
use App\Livewire\Pages\Common\Bookings\UserBooking;
use App\Livewire\Pages\Common\Dispute\Dispute;
use App\Livewire\Pages\Common\Dispute\ManageDispute;
use App\Livewire\Pages\Common\ProfileSettings\AccountSettings;
use App\Livewire\Pages\Common\ProfileSettings\IdentityVerification;
use App\Livewire\Pages\Common\ProfileSettings\PersonalDetails;
use App\Livewire\Pages\Common\ProfileSettings\Resume;
use App\Livewire\Pages\Student\BillingDetail\BillingDetail;
use App\Livewire\Pages\Student\CertificateList;
use App\Livewire\Pages\Student\Favourite\Favourites;
use App\Livewire\Pages\Student\Invoices;
use App\Livewire\Pages\Student\RescheduleSession;

use App\Livewire\Pages\Tutor\ManageAccount\ManageAccount;
use App\Livewire\Pages\Tutor\ManageSessions\ManageSubjects;
use App\Livewire\Pages\Tutor\CompanyCourses\Courses;
use App\Http\Controllers\PaymentController;

use App\Livewire\Pages\Tutor\ManageSessions\MyCalendar;
use App\Livewire\Pages\Tutor\ManageSessions\SessionDetail;
use App\Livewire\Payouts;
use App\Livewire\BuscarTutor;
use App\Livewire\BuscadorTutor;
use App\Http\Controllers\GoogleMeetController;
use App\Services\GoogleMeetService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorPerfilController;
use App\Http\Controllers\BeforeBlogsController;
use App\Http\Controllers\BookingController;

use App\Http\Controllers\Api\SubjectPickerController;
use App\Livewire\PruebaABEL;
use App\Mail\TutoriaInstanteNotificacionMail;

use Illuminate\Support\Facades\Mail;


use App\Http\Controllers\pruebaController;

Route::get('/prueba/{id}', [pruebaController::class, 'debugMeetLink']);

// Route::get('/probar-correo', function () {

//     Mail::send('emails.confirmationTutorInstant', [], function ($message) {
//         $message->to('ronaldflores200403@gmail.com')
//             ->subject('Prueba de diseño');
//     });

//     return 'Correo enviado';
// });

Route::get('/probar-correo', function () {

    $to = 'ronaldflores200403@gmail.com';

    $random = "hola mundo";
    $lines = [
        "Hola 👋",
        "Tu código random es: {$random}",
        "Hora servidor: " . now()->toDateTimeString(),
        "Fin ✅",
    ];

    Mail::raw(implode("\n", $lines), function ($message) use ($to, $random) {
        $message->to($to)
            ->subject("Prueba random {$random}");

    });

    return "Correo enviado a {$to} (código: {$random})";
});


Route::get('/control-horas', function () {
    return view('vistas.view.pages.hora');
});


Route::middleware(['auth'])->group(function () {
    // Ejemplo de ruta para gestionar materiales de apoyo
    Route::get('/student/tutorias', \App\Livewire\TutoriasDetalles::class)
        ->name('student.tutorias');
        Route::get('/tutor/tutorias', \App\Livewire\TutoriasDetalles::class)
        ->name('tutor.tutorias');
});
// Route::get('/waitlist/accept', [SubjectPickerController::class, 'acceptWaitlist'])
//     ->name('waitlist.accept');

// Route::post('/send-last-5', [SubjectPickerController::class, 'sendLastFive']);
// Route::get('/send-last-5', [SubjectPickerController::class, 'sendLastFive']);

// ==================== TUTOR (NO middleware, token) ====================
Route::get('/tutor/waitlist/accept', [SubjectPickerController::class, 'acceptWaitlist'])->name('waitlist.accept');

Route::get('/tutor/waitlist/status', [SubjectPickerController::class, 'tutorWaitlistStatus']);

Route::post('/tutor/waitlist/accept', [SubjectPickerController::class, 'tutorAcceptBooking']);

Route::post('/tutor/waitlist/reject', [SubjectPickerController::class, 'tutorRejectBooking']);
Route::post('/bookings/{id}/check-meet', [SubjectPickerController::class, 'checkMeetLink'])
    ->name('bookings.checkMeet');



Route::view('/reserva', 'vistas.view.pages.e')->name('e');
Route::view('/traduccion', 'vistas.view.pages.traduccion')->name('traduccion');




Route::get('/verify', function (\Illuminate\Http\Request $request) {
    $id = $request->query('id');
    $hash = $request->query('hash');
    $status = null;
    $message = null;
    $redirect = null;

    if ($id && $hash) {
        $user = \App\Models\User::find($id);
        if ($user && hash_equals($hash, sha1($user->email))) {
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
                $user->save();
                $status = 'success';
                $message = 'Correo verificado correctamente.';
            } else {
                $status = 'info';
                $message = 'El correo ya estaba verificado.';
            }
            // Redirección según el rol
            if ($user->hasRole('tutor')) {
                $redirect = url('/tutor/dashboard');
            } elseif ($user->hasRole('student')) {
                $redirect = url('/student/bookings');
            }
        } else {
            $status = 'error';
            $message = 'El enlace de verificación no es válido.';
        }
    } else {
        $status = 'error';
        $message = 'Parámetros inválidos.';
    }

    return view('verify', [
        'status' => $status,
        'message' => $message,
        'redirect' => $redirect,
        'id' => $id,
        'hash' => $hash,
    ]);
});
Route::get('/prueba', function () {
    return '¡Ruta de prueba funcionando!';
});;

// web.php


//OJO -------> Debe de estar dentro del grupo de rutas para el rol TUTOR
//Route::get('{slug}/ficha/{id}', [ExportImageController::class, 'exportFicha'])->name('tutor.ficha');
Route::get('/tutor/ficha/{slug}/{id}', [ExportImageController::class, 'index'])->name('tutor.ficha');
Route::get('/tutor/ficha-img/{slug}/{id}', [ExportImageController::class, 'exportFicha'])->name('tutor.ficha.img');
Route::get('/tutor/ficha-download/{slug}/{id}', [ExportImageController::class, 'downloadFicha'])->name('tutor.ficha.download');



Route::get('auth/{provider}', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');

Route::get('/pay-qr/{orderId}', [PaymentController::class, 'showQR'])->name('pay-qr');

Route::get('/google/authenticate', [GoogleController::class, 'authenticate'])->name('google.authenticate');
Route::get('/auth/api/google/callback', [GoogleController::class, 'googlecallback'])->name('google.callback');
Route::get('/auth/api/google/prerequisites/callback',[GoogleController::class, 'googlePrerequisitesCallback'])->name('google.prerequisites.callback');



//Route::get('calendar/google/callback', [GoogleController::class, 'googleCallback'])->name('googlecal.callback');




//Route::get('auth/{provider}', [Go::class, 'redirect'])->name('social.redirect');

Route::get('/conferences', [ConferencesController::class, 'index'])
    ->name('conferences.index');

Route::middleware(['locale', 'maintenance'])->group(function () {
    //Route::get('find-tutors', [SearchController::class, 'findTutors'])->name('find-tutors');
    //Route::get('find-tutors', [SearchController::class, 'findTutors'])->name('find-tutors');

    // Route::get('/blogs', Blogs::class)->name('blogs');
    Route::get('/blog/{slug}', BlogDetails::class)->name('blog-details');
    Route::view('/subscriptions-page', 'subscriptions-page');

    // <==== Grillo kkk ===>
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
    Route::view('/como-trabajamos', 'vistas.view.pages.trabajamos')->name('como-trabajamos');
    Route::view('/preguntas', 'vistas.view.pages.preguntas')->name('preguntas');
    Route::get('/tutores/{slug}', [HomeController::class, 'tutor'])->name('tutor');
    Route::get('/tutors', [HomeController::class, 'buscarTutor'])->name('buscar.tutor'); //<---ojo
    Route::get('/buscar', [HomeController::class, 'buscar'])->name('buscar');
    Route::view('/modal', 'vistas.view.pages.modals.modal-reserva')->name('modal');
    Route::get('/tutorias-instantaneas', [InstantTutoringController::class, 'index'])->name('tutorias-instantaneas');

    Route::post('/tutor/{tutorId}/review', [HomeController::class, 'storeReview'])
        ->name('tutor.review.store')
        ->middleware(['auth', 'role:student']);


    //<=== Kevin Pasante ===>
    Route::view('/terminos', 'vistas.view.pages.terminos')->name('terminos');

    /////////////////////////////////////////////////////////////////////
    //<=== Oscar Pasante ===>
    // Route::view('/blogs','vistas.view.pages.blog')->name('blogs');
    Route::get('/blogs', [BeforeBlogsController::class, 'index'])->name('blogs.index');

    Route::get('/blogs/{blog:slug}', [BeforeBlogsController::class, 'showBySlug'])->name('blogs.show');

    ///Ruta para la encuesta
    Route::post('/encuesta/guardar', [HomeController::class, 'storeEncuesta'])->name('encuesta.store');
    //<===//////////////////////////////////////////===>

    //Route::get('/buscar-tutor', BuscarTutor::class)->name('buscar.tutor');
    Route::get('/kkkk', BuscadorTutor::class)->name('buscador.tutor');



    Route::get('/promociones', [PromocionesController::class, 'index'])->name('promociones');
    // routes/web.php
    Route::post('/promociones/canjear', [PromocionesController::class, 'canjear'])
        ->name('coupons.canjear')
        ->middleware('auth');

    // promociones vista ejemplo    
    Route::post('tutor/favourite', [SearchController::class, 'favouriteTutor'])->name('tutor.favourite');



    Route::middleware(['auth', 'verified', 'onlineUser'])->group(function () {
        Route::post('/openai/submit', [OpenAiController::class, 'submit'])->name('openai.submit');
        Route::post('/accept-terms', [HomeController::class, 'acceptTerms'])->name('accept.terms');
        Route::post('favourite-tutor', [SearchController::class, 'favouriteTutor'])->name('favourite-tutor');
        Route::get('logout', [SiteController::class, 'logout'])->name('logout');
        Route::get('user/identity-confirmation/{id}', [PersonalDetails::class, 'confirmParentVerification'])->name('confirm-identity');

        Route::get('google/callback', [SiteController::class, 'getGoogleToken']);

        Route::middleware('student')->get('checkout', Checkout::class)->name('checkout');
        Route::middleware('student')->get('thank-you/{id}', ThankYou::class)->name('thank-you');

        Route::middleware('role:tutor')->prefix('tutor')->name('tutor.')->group(function () {
            Route::get('finances', ManageAccount::class)->name('finances');
            Route::get('dashboard', \App\Livewire\TutoriasDetalles::class)->name('dashboard');
            Route::get('payouts', Payouts::class)->name('payouts');
            Route::get('profile', fn() => redirect('tutor.profile.personal-details'))->name('profile');

            //Route::get('/descargar-ficha/{id}', [ExportImageController::class, 'exportFicha'])->name('ficha');


            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('personal-details', PersonalDetails::class)->name('personal-details');
                Route::get('account-settings', AccountSettings::class)->name('account-settings');
                Route::get('courses', Courses::class)->name('courses');
                Route::prefix('resume')->name('resume.')->group(function () {
                    Route::get('education', Resume::class)->name('education');
                    Route::get('experience', Resume::class)->name('experience');
                    Route::get('certificate', Resume::class)->name('certificate');
                });
                Route::get('identification', IdentityVerification::class)->name('identification');
            });
            Route::prefix('bookings')->name('bookings.')->group(function () {
                Route::get('manage-subjects', ManageSubjects::class)->name('subjects');
                Route::get('manage-sessions', MyCalendar::class)->name('manage-sessions');
                Route::get('session-detail/{date}', SessionDetail::class)->name('session-detail');
                Route::get('upcoming-bookings', UserBooking::class)->name('upcoming-bookings');
            });

            Route::get('invoices', Invoices::class)->name('invoices');
            Route::get('disputes', Dispute::class)->name('disputes');
            Route::get('manage-dispute/{id}', ManageDispute::class)->name('manage-dispute');
        });

        Route::middleware('student')->prefix('student')->name('student.')->group(function () {

            //ruta final tutors instant

            Route::get('/gg', function () {
                return view('vistas.view.pages.tutors-instant-cards');
            })
                ->name('tutors.instant');
            //ruta final tutors instant

            /////////////////////////////////////oscar tutor-instant//////////////////////////////////////////////



            Route::get('/materias/elegir',[InstantTutoringController::class, 'index'])
                ->name('subjects.pick');



            Route::get('/subjects/{subject_id}/tutors/available-now', [SubjectPickerController::class, 'tutorsAvailableNow']); //tutores disponibles ahora
            Route::get('/subjects/{subject_id}/tutors/not-available-now', [SubjectPickerController::class, 'tutorsNotAvailableNow']); //tutores no disponibles ahora

            Route::post('/batches/start', [SubjectPickerController::class, 'start']); // este envia los emails para el boton go inicializa todo
            Route::post('/batches/{batch}/cancel', [SubjectPickerController::class, 'cancelBatch'])->name('batches.cancel');        
            Route::get('/batches/{batch}/status', [SubjectPickerController::class, 'status']); //estado de la batch
            Route::get('/batches/active', [SubjectPickerController::class, 'active']); //batch activa si hay
            Route::get('/subjects/{subject_id}/tutors', [SubjectPickerController::class, 'tutorsBySubject']); //tutores por materia
            /////////// oscar api/endpoint ///////////////////////////////////////

        
            Route::get('/subject-groups/categorias-materias', [SubjectPickerController::class, 'categoriasMaterias']); //categorias y materias finales (en uso)


            Route::get('/subject', [SubjectPickerController::class, 'index']); //lista de materias


            Route::post('/batches/start', [SubjectPickerController::class, 'start']); //iniciar batch (este es para mi btn go)

            Route::post('/batches/send-emails', [SubjectPickerController::class, 'sendBatchEmails']); //enviar emails (este es para enviar los emails, se puede optimizar para que se ejecute automáticamente al iniciar la batch)

            Route::post('/batches/{batch}/dispatch', [SubjectPickerController::class, 'dispatchEmails'])
                ->name('batches.dispatch');
            Route::get('/batches/{batch}/dispatch',     [SubjectPickerController::class, 'dispatchEmails'])
                ->name('batches.dispatchd');
            Route::post('/batches/{batch}/choose', [SubjectPickerController::class, 'chooseTutor'])
                ->name('batches.choose');

            Route::get('/batches/{batch}/accepted-tutors', [SubjectPickerController::class, 'acceptedTutors']);

            Route::post('/batches/{batch}/reserve', [SubjectPickerController::class, 'reserveTutor']);

            Route::get('/bookings/{bookingId}/ttl', [SubjectPickerController::class, 'getBookingTtl']); // Obtener TTL del booking
            Route::post('/bookings/{bookingId}/expire', [SubjectPickerController::class, 'expireBooking']); // Expirar booking cuando pase el TTL
            Route::post('/bookings/{bookingId}/force-expire', [SubjectPickerController::class, 'forceExpireBooking']); // Expirar forzadamente (admin)

            // Route::post('/bookings/{booking}/receipt', [SubjectPickerController::class, 'uploadReceipt']);

            // Route::get('/bookings/{booking}/status', [SubjectPickerController::class, 'studentBookingStatus']);

            Route::post('/bookings/{booking}/receipt', [SubjectPickerController::class, 'studentUploadReceipt']);
            Route::get('/bookings/{booking}/status', [SubjectPickerController::class, 'studentBookingStatus']);

            Route::post('/batches/{batch}/request-booking', [SubjectPickerController::class, 'requestBooking']);


            Route::get('/bookings/{booking}/meet', [SubjectPickerController::class, 'studentMeet']);
            

            /////////////////////////////////////////////////////////////////////////////////////////////////////////
            Route::get('profile', fn() => redirect('tutor.profile.personal-details'))->name('profile');
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('personal-details', PersonalDetails::class)->name('personal-details');
                Route::get('account-settings', AccountSettings::class)->name('account-settings');
                Route::get('identification', IdentityVerification::class)->name('identification');
            });
            Route::get('bookings', UserBooking::class)->name('bookings');
            Route::get('invoices', Invoices::class)->name('invoices');

            Route::get('favourites', Favourites::class)->name('favourites');
            Route::get('reschedule-session/{id}', RescheduleSession::class)->name('reschedule-session');
            Route::get('complete-booking/{id}', [SiteController::class, 'completeBooking'])->name('complete-booking');
            Route::get('certificates', CertificateList::class)->name('certificate-list');
            Route::get('disputes', Dispute::class)->name('disputes');
            Route::get('manage-dispute/{id}', ManageDispute::class)->name('manage-dispute');

            // Rutas para el wizard de reservas (requiere autenticación de estudiante)
            Route::prefix('booking')->name('booking.')->group(function () {
                Route::get('/niveles', [BookingController::class, 'getLevels'])->name('niveles');
                Route::get('/categorias', [BookingController::class, 'getCategories'])->name('categorias');
                Route::get('/materias', [BookingController::class, 'getSubjects'])->name('materias');
                // Route::get('/tutores/{subject_id}', [BookingController::class, 'getTutors'])->name('tutores');
                Route::get('/tutores', [BookingController::class, 'getTutors'])->name('tutores');
                Route::get('/horarios/{tutor_id}', [BookingController::class, 'getSlots'])->name('horarios');
                Route::get('/tutor-payment/{tutor_id}', [BookingController::class, 'getTutorPayment'])->name('tutor-payment');

                // RUTAS NUEVAS PARA MULTI-SLOT BOOKING
                Route::get('/horarios-multi/{tutor_id}', [BookingController::class, 'getSlotsMulti'])->name('horarios-multi');
                Route::post('/hold-slots', [BookingController::class, 'holdSlotsMulti'])->name('hold-slots');
                Route::post('/release-slots', [BookingController::class, 'releaseSlotsMulti'])->name('release-slots');
                Route::post('/reservar-multi', [BookingController::class, 'storeMultiBooking'])->name('reservar-multi');

                Route::post('/validar-cupon', [BookingController::class, 'validateCoupon'])->name('validar-cupon');
                Route::post('/reservar', [BookingController::class, 'storeBooking'])->name('reservar');
                Route::post('/solicitar-tutor', [BookingController::class, 'solicitarTutor'])->name('solicitar-tutor');
                Route::get('/get-counter/{token}', [BookingController::class, 'getCounterDetails'])->name('get-counter');
            });
        });
    });

    Route::post('/remove-cart', [SiteController::class, 'removeCart']);

    // Rutas para la negociación de horarios (Ping-Pong) con tokens
    Route::get('/solicitud-clase/{token}', [BookingController::class, 'showNegotiation'])->name('tutor-request.negotiate');
    Route::post('/solicitud-clase/{token}/rechazar', [BookingController::class, 'rejectNegotiation'])->name('tutor-request.reject');
    Route::post('/solicitud-clase/{token}/contraofertar', [BookingController::class, 'counterNegotiation'])->name('tutor-request.counter');
    Route::post('/solicitud-clase/{token}/aceptar', [BookingController::class, 'acceptNegotiation'])->name('tutor-request.accept');

    Route::get('tutor/{slug}', [SearchController::class, 'tutorDetail'])->name('tutor-detail');
    Route::get('{gateway}/process/payment', [SiteController::class, 'processPayment'])->name('payment.process');
    Route::get('checkout/cancel', fn() => redirect()->route('invoices')->with('payment_cancel', __('general.payment_cancelled_desc')))->name('checkout.cancel');
    Route::post('payfast/webhook', [SiteController::class, 'payfastWebhook'])->name('payfast.webhook');
    Route::post('payment/success', [SiteController::class, 'paymentSuccess'])->name('post.success');
    Route::get('payment/success', [SiteController::class, 'paymentSuccess'])->name('get.success');
    Route::post('switch-lang', [SiteController::class, 'switchLang'])->name('switch-lang');
    Route::post('switch-currency', [SiteController::class, 'switchCurrency'])->name('switch-currency');
    Route::get('exit-impersonate', [Impersonate::class, 'exitImpersonate'])->name('exit-impersonate');
    Route::get('pay/{id}', [SiteController::class, 'preparePayment'])->name('pay');
    require __DIR__ . '/auth.php';

    require __DIR__ . '/admin.php';
    require __DIR__ . '/optionbuilder.php';
    if (!request()->is('api/*')) {
        require __DIR__ . '/pagebuilder.php';
    }


    // routes/web.php

});

 Route::get('/tutor/{id}', [TutorPerfilController::class, 'show'])->name('tutor.perfil');
