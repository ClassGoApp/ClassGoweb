# 📚 Documentación Técnica del Proyecto ClassGo

**Versión:** 1.0  
**Fecha:** Noviembre 2025  
**Framework:** Laravel 10.x con Livewire 3.x  
**Propósito:** Plataforma de tutorías en línea

---

## 📋 Tabla de Contenidos

1. [Introducción](#introducción)
2. [Estructura General del Proyecto](#estructura-general-del-proyecto)
3. [Arquitectura MVC](#arquitectura-mvc)
4. [Controladores](#controladores)
5. [Modelos](#modelos)
6. [Vistas](#vistas)
7. [Componentes Livewire](#componentes-livewire)
8. [Rutas](#rutas)
9. [API](#api)
10. [Servicios](#servicios)

---

## 🎯 Introducción

ClassGo es una plataforma web desarrollada en Laravel que conecta estudiantes con tutores para sesiones de tutoría en línea. El sistema permite:

- Registro y autenticación de usuarios (estudiantes y tutores)
- Búsqueda y filtrado de tutores por materia
- Reserva de sesiones de tutoría
- Sistema de pagos y facturación
- Gestión de calendarios y disponibilidad
- Sistema de reseñas y calificaciones
- Integración con Google Calendar y Google Meet

---

## 📁 Estructura General del Proyecto

```
ClassGoweb/
├── app/                          # Lógica de la aplicación
│   ├── Http/Controllers/         # Controladores HTTP
│   ├── Models/                   # Modelos Eloquent
│   ├── Livewire/                 # Componentes Livewire
│   ├── Services/                 # Servicios de negocio
│   ├── Mail/                     # Clases de correo
│   ├── Jobs/                     # Trabajos en cola
│   └── Providers/                # Proveedores de servicios
├── resources/                    # Recursos del frontend
│   ├── views/                    # Plantillas Blade
│   ├── css/                      # Estilos CSS
│   └── js/                       # JavaScript
├── routes/                       # Definición de rutas
│   ├── web.php                   # Rutas web
│   ├── api.php                   # Rutas API
│   └── admin.php                 # Rutas administrativas
├── database/                     # Base de datos
│   ├── migrations/               # Migraciones
│   └── seeders/                  # Seeders
├── public/                       # Archivos públicos
└── config/                       # Configuraciones
```

---

## 🏗️ Arquitectura MVC

ClassGo sigue el patrón **Modelo-Vista-Controlador (MVC)** de Laravel:

### **Modelo (Model)**

- Ubicación: `app/Models/`
- Responsabilidad: Interactuar con la base de datos
- Ejemplo: `User.php`, `SlotBooking.php`, `Review.php`

### **Vista (View)**

- Ubicación: `resources/views/`
- Responsabilidad: Presentar datos al usuario
- Tecnología: Blade Templates + Livewire

### **Controlador (Controller)**

- Ubicación: `app/Http/Controllers/`
- Responsabilidad: Manejar lógica de negocio y coordinar Modelo-Vista
- Tipos: Controladores Web, API, Admin

---

## 🎮 Controladores

### 📂 Estructura de Controladores

```
app/Http/Controllers/
├── Admin/                        # Controladores administrativos
│   ├── TutorController.php       # Gestión de tutores
│   └── ...
├── Api/                          # Controladores API REST
│   ├── AuthController.php        # Autenticación API
│   ├── TutorController.php       # Endpoints de tutores
│   ├── BookingController.php     # Gestión de reservas
│   ├── ReviewController.php      # Sistema de reseñas
│   └── ...
├── Auth/                         # Autenticación
│   └── SocialController.php      # Login social (Google)
├── Frontend/                     # Controladores del frontend
│   └── SearchController.php      # Búsqueda de tutores
└── [Controladores raíz]
    ├── HomeController.php        # Página principal
    ├── SiteController.php        # Funciones generales del sitio
    ├── PaymentController.php     # Procesamiento de pagos
    └── GoogleMeetController.php  # Integración Google Meet
```

### 🔑 Controladores Principales

#### **HomeController.php**

- **Ruta:** `app/Http/Controllers/HomeController.php`
- **Propósito:** Gestionar las páginas principales del sitio
- **Métodos principales:**
  - `index()`: Página de inicio
  - `nosotros()`: Página "Nosotros"
  - `tutor($slug)`: Detalle de tutor
  - `buscarTutor()`: Página de búsqueda
  - `storeReview()`: Guardar reseñas

**Rutas asociadas:**

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/tutores/{slug}', [HomeController::class, 'tutor'])->name('tutor');
```

---

#### **SiteController.php**

- **Ruta:** `app/Http/Controllers/SiteController.php`
- **Propósito:** Funcionalidades generales del sitio
- **Métodos principales:**
  - `logout()`: Cerrar sesión
  - `processPayment()`: Procesar pagos
  - `paymentSuccess()`: Confirmación de pago
  - `switchLang()`: Cambiar idioma
  - `switchCurrency()`: Cambiar moneda

---

#### **PaymentController.php**

- **Ruta:** `app/Http/Controllers/PaymentController.php`
- **Propósito:** Gestión de pagos QR
- **Métodos principales:**
  - `showQR()`: Mostrar código QR de pago

**Ruta asociada:**

```php
Route::get('/pay-qr/{orderId}', [PaymentController::class, 'showQR'])->name('pay-qr');
```

---

### 🌐 Controladores API

#### **Api/AuthController.php**

- **Ruta:** `app/Http/Controllers/Api/AuthController.php`
- **Propósito:** Autenticación para API móvil
- **Endpoints:**
  - `POST /api/login`: Iniciar sesión
  - `POST /api/register`: Registrar usuario
  - `POST /api/logout`: Cerrar sesión
  - `POST /api/forget-password`: Recuperar contraseña
  - `POST /api/update-fcm-token`: Actualizar token de notificaciones

---

#### **Api/TutorController.php**

- **Ruta:** `app/Http/Controllers/Api/TutorController.php`
- **Propósito:** Gestión de tutores vía API
- **Endpoints:**
  - `GET /api/find-tutors`: Buscar tutores
  - `GET /api/verified-tutors`: Tutores verificados
  - `GET /api/tutor/{slug}`: Detalle de tutor
  - `GET /api/tutor-available-slots`: Slots disponibles
  - `GET /api/available-tutors`: Tutores disponibles ahora

---

#### **Api/BookingController.php**

- **Ruta:** `app/Http/Controllers/Api/BookingController.php`
- **Propósito:** Gestión de reservas de tutorías
- **Endpoints:**
  - `GET /api/upcoming-bookings`: Próximas tutorías
  - `GET /api/user/{id}/bookings`: Tutorías de un usuario
  - `POST /api/slot-bookings`: Crear nueva reserva
  - `POST /api/test-payment-upload`: Subir comprobante de pago

---

#### **Api/ReviewController.php**

- **Ruta:** `app/Http/Controllers/Api/ReviewController.php`
- **Propósito:** Sistema de reseñas y calificaciones
- **Endpoints:**
  - `GET /api/reviews`: Listar reseñas
  - `POST /api/reviews`: Crear reseña
  - `GET /api/reviews/{id}`: Ver reseña
  - `PUT /api/reviews/{id}`: Actualizar reseña
  - `DELETE /api/reviews/{id}`: Eliminar reseña
  - `GET /api/reviews/stats/{userId}`: Estadísticas de reseñas

---

#### **Api/UserSubjectController.php**

- **Ruta:** `app/Http/Controllers/Api/UserSubjectController.php`
- **Propósito:** Gestión de materias de tutores
- **Endpoints:**
  - `GET /api/tutor-subjects`: Listar materias del tutor
  - `POST /api/tutor-subjects`: Agregar materia
  - `DELETE /api/tutor/{tutor_id}/subjects/{subject_id}`: Eliminar materia

---

## 📊 Modelos

### 📂 Ubicación

`app/Models/`

### 🔑 Modelos Principales

#### **User.php**

- **Tabla:** `users`
- **Propósito:** Usuarios del sistema (estudiantes y tutores)
- **Relaciones:**
  - `hasMany(SlotBooking)`: Reservas como estudiante
  - `hasMany(SlotBooking, 'tutor_id')`: Reservas como tutor
  - `hasMany(UserSubject)`: Materias que enseña
  - `hasMany(Review)`: Reseñas recibidas
  - `hasMany(UserEducation)`: Educación
  - `hasMany(UserExperience)`: Experiencia
  - `belongsToMany(Role)`: Roles (student, tutor, admin)

**Campos importantes:**

- `name`, `email`, `password`
- `role`: Rol del usuario
- `slug`: URL amigable
- `available_for_tutoring`: Disponibilidad actual
- `profile_image`: Foto de perfil
- `hourly_rate`: Tarifa por hora

---

#### **SlotBooking.php**

- **Tabla:** `slot_bookings`
- **Propósito:** Reservas de tutorías
- **Relaciones:**
  - `belongsTo(User, 'student_id')`: Estudiante
  - `belongsTo(User, 'tutor_id')`: Tutor
  - `belongsTo(Subject)`: Materia
  - `hasMany(PaymentSlotBooking)`: Pagos asociados

**Campos importantes:**

- `student_id`, `tutor_id`, `subject_id`
- `booking_date`, `start_time`, `end_time`
- `status`: Estado (pending, accepted, completed, cancelled)
- `price`: Precio de la sesión
- `meet_link`: Enlace de Google Meet

---

#### **Review.php**

- **Tabla:** `reviews`
- **Propósito:** Reseñas y calificaciones
- **Relaciones:**
  - `belongsTo(User, 'reviewer_id')`: Quien escribe la reseña
  - `belongsTo(User, 'reviewed_id')`: Quien recibe la reseña
  - `belongsTo(SlotBooking)`: Reserva asociada

**Campos importantes:**

- `reviewer_id`, `reviewed_id`
- `rating`: Calificación (1-5)
- `comment`: Comentario
- `is_approved`: Aprobación del admin

---

#### **Subject.php**

- **Tabla:** `subjects`
- **Propósito:** Materias/asignaturas
- **Relaciones:**
  - `belongsTo(SubjectGroup)`: Grupo de materia
  - `hasMany(UserSubject)`: Tutores que la enseñan

---

#### **UserSubject.php**

- **Tabla:** `user_subjects`
- **Propósito:** Relación tutor-materia
- **Relaciones:**
  - `belongsTo(User)`: Tutor
  - `belongsTo(Subject)`: Materia
  - `hasMany(UserSubjectSlot)`: Horarios disponibles

---

#### **PaymentSlotBooking.php**

- **Tabla:** `payment_slot_bookings`
- **Propósito:** Pagos de reservas
- **Relaciones:**
  - `belongsTo(SlotBooking)`: Reserva
  - `belongsTo(User)`: Usuario que paga

**Campos importantes:**

- `slot_booking_id`
- `payment_method`: Método de pago
- `payment_proof`: Comprobante de pago
- `status`: Estado del pago

---

### 📋 Lista Completa de Modelos

| Modelo                    | Tabla                 | Propósito                |
| ------------------------- | --------------------- | ------------------------ |
| `User.php`                | users                 | Usuarios del sistema     |
| `SlotBooking.php`         | slot_bookings         | Reservas de tutorías     |
| `Review.php`              | reviews               | Reseñas y calificaciones |
| `Subject.php`             | subjects              | Materias/asignaturas     |
| `SubjectGroup.php`        | subject_groups        | Grupos de materias       |
| `UserSubject.php`         | user_subjects         | Materias de tutores      |
| `UserSubjectSlot.php`     | user_subject_slots    | Horarios disponibles     |
| `PaymentSlotBooking.php`  | payment_slot_bookings | Pagos de reservas        |
| `Order.php`               | orders                | Órdenes de compra        |
| `OrderItem.php`           | order_items           | Items de órdenes         |
| `Coupon.php`              | coupons               | Cupones de descuento     |
| `UserCoupon.php`          | user_coupons          | Cupones de usuarios      |
| `UserEducation.php`       | user_educations       | Educación de tutores     |
| `UserExperience.php`      | user_experiences      | Experiencia de tutores   |
| `UserCertificate.php`     | user_certificates     | Certificados de tutores  |
| `UserLanguage.php`        | user_languages        | Idiomas de tutores       |
| `Profile.php`             | profiles              | Perfiles de usuario      |
| `Address.php`             | addresses             | Direcciones              |
| `Country.php`             | countries             | Países                   |
| `CountryState.php`        | country_states        | Estados/provincias       |
| `Language.php`            | languages             | Idiomas del sistema      |
| `Blog.php`                | blogs                 | Artículos del blog       |
| `BlogCategory.php`        | blog_categories       | Categorías de blog       |
| `Dispute.php`             | disputes              | Disputas                 |
| `DisputeConversation.php` | dispute_conversations | Mensajes de disputas     |
| `FavouriteUser.php`       | favourite_users       | Tutores favoritos        |
| `Alianza.php`             | alianzas              | Alianzas/partners        |
| `Conferences.php`         | conferences           | Conferencias             |

---

## 🎨 Vistas

### 📂 Estructura de Vistas

```
resources/views/
├── components/                   # Componentes Blade reutilizables
│   ├── buscar-tutor.blade.php    # Buscador de tutores
│   ├── featured-tutors.blade.php # Tutores destacados
│   ├── booking-detail-modal.blade.php # Modal de reserva
│   └── ...
├── frontend/                     # Vistas del frontend
│   ├── find-tutors.blade.php     # Búsqueda de tutores
│   └── tutor-detail.blade.php    # Detalle de tutor
├── vistas/view/pages/            # Páginas principales
│   ├── trabajamos.blade.php      # Cómo trabajamos
│   ├── preguntas.blade.php       # Preguntas frecuentes
│   ├── terminos.blade.php        # Términos y condiciones
│   └── blog.blade.php            # Blog
├── emails/                       # Plantillas de correo
│   ├── session-booking.blade.php # Confirmación de reserva
│   ├── tutor-tutoria-notification.blade.php
│   └── student-tutoria-notification.blade.php
├── errors/                       # Páginas de error
│   ├── 404.blade.php
│   ├── 500.blade.php
│   └── ...
├── livewire/                     # Vistas de componentes Livewire
└── layouts/                      # Layouts principales
```

### 🔑 Vistas Principales

#### **home-eight.blade.php**

- **Ruta:** `resources/views/home-eight.blade.php`
- **Propósito:** Página de inicio
- **Componentes incluidos:**
  - Buscador de tutores
  - Tutores destacados
  - Contadores de estadísticas
  - Alianzas

---

#### **frontend/find-tutors.blade.php**

- **Ruta:** `resources/views/frontend/find-tutors.blade.php`
- **Propósito:** Página de búsqueda de tutores
- **Controlador:** `SearchController@findTutors`

---

#### **frontend/tutor-detail.blade.php**

- **Ruta:** `resources/views/frontend/tutor-detail.blade.php`
- **Propósito:** Perfil detallado del tutor
- **Controlador:** `SearchController@tutorDetail`
- **Componentes:**
  - Información del tutor
  - Materias que enseña
  - Calendario de disponibilidad
  - Reseñas
  - Botón de reserva

---

## ⚡ Componentes Livewire

Livewire permite crear componentes interactivos sin escribir JavaScript. Cada componente tiene:

- **Clase PHP:** Lógica del componente
- **Vista Blade:** Presentación

### 📂 Estructura

```
app/Livewire/
├── Pages/                        # Páginas completas
│   ├── Common/                   # Compartidas entre roles
│   │   ├── Bookings/
│   │   │   └── UserBooking.php   # Lista de reservas
│   │   ├── Dispute/
│   │   │   ├── Dispute.php       # Lista de disputas
│   │   │   └── ManageDispute.php # Gestionar disputa
│   │   └── ProfileSettings/
│   │       ├── PersonalDetails.php
│   │       ├── AccountSettings.php
│   │       ├── Resume.php
│   │       └── IdentityVerification.php
│   ├── Tutor/                    # Específicas de tutores
│   │   ├── ManageAccount/
│   │   │   └── ManageAccount.php # Dashboard del tutor
│   │   ├── ManageSessions/
│   │   │   ├── ManageSubjects.php
│   │   │   ├── MyCalendar.php
│   │   │   └── SessionDetail.php
│   │   └── CompanyCourses/
│   │       └── Courses.php
│   └── Student/                  # Específicas de estudiantes
│       ├── Favourite/
│       │   └── Favourites.php    # Tutores favoritos
│       ├── BillingDetail/
│       │   └── BillingDetail.php
│       ├── Invoices.php
│       └── RescheduleSession.php
├── Frontend/                     # Frontend público
│   ├── Blogs.php                 # Lista de blogs
│   ├── BlogDetails.php           # Detalle de blog
│   ├── Checkout.php              # Proceso de pago
│   └── ThankYou.php              # Confirmación
├── Forms/                        # Formularios reutilizables
├── Components/                   # Componentes pequeños
├── Reserva.php                   # Componente de reserva
├── BuscarTutor.php               # Búsqueda de tutores
├── TutorReviews.php              # Reseñas de tutor
└── Payouts.php                   # Pagos a tutores
```

### 🔑 Componentes Livewire Principales

#### **Reserva.php**

- **Clase:** `app/Livewire/Reserva.php`
- **Vista:** `resources/views/livewire/reserva.blade.php`
- **Propósito:** Gestionar el proceso de reserva de tutorías
- **Funcionalidades:**
  - Seleccionar tutor y materia
  - Elegir fecha y hora
  - Procesar pago
  - Confirmar reserva

**Ruta asociada:**

```php
Route::view('/reserva', 'vistas.view.pages.e')->name('e');
```

---

#### **Pages/Tutor/ManageAccount/ManageAccount.php**

- **Clase:** `app/Livewire/Pages/Tutor/ManageAccount/ManageAccount.php`
- **Vista:** `resources/views/livewire/pages/tutor/manage-account/manage-account.blade.php`
- **Propósito:** Dashboard del tutor
- **Funcionalidades:**
  - Estadísticas de ganancias
  - Próximas sesiones
  - Resumen de actividad

**Ruta asociada:**

```php
Route::get('tutor/dashboard', ManageAccount::class)->name('tutor.dashboard');
```

---

#### **Pages/Common/Bookings/UserBooking.php**

- **Clase:** `app/Livewire/Pages/Common/Bookings/UserBooking.php`
- **Vista:** `resources/views/livewire/pages/common/bookings/user-booking.blade.php`
- **Propósito:** Lista de reservas del usuario
- **Funcionalidades:**
  - Ver reservas pasadas y futuras
  - Filtrar por estado
  - Cancelar reservas
  - Acceder a enlaces de Meet

**Rutas asociadas:**

```php
// Para tutores
Route::get('tutor/bookings/upcoming-bookings', UserBooking::class)
    ->name('tutor.bookings.upcoming-bookings');

// Para estudiantes
Route::get('student/bookings', UserBooking::class)
    ->name('student.bookings');
```

---

#### **Pages/Common/ProfileSettings/PersonalDetails.php**

- **Clase:** `app/Livewire/Pages/Common/ProfileSettings/PersonalDetails.php`
- **Vista:** `resources/views/livewire/pages/common/profile-settings/personal-details.blade.php`
- **Propósito:** Editar información personal
- **Funcionalidades:**
  - Actualizar nombre, email, teléfono
  - Cambiar foto de perfil
  - Actualizar biografía
  - Gestionar idiomas

**Rutas asociadas:**

```php
// Para tutores
Route::get('tutor/profile/personal-details', PersonalDetails::class)
    ->name('tutor.profile.personal-details');

// Para estudiantes
Route::get('student/profile/personal-details', PersonalDetails::class)
    ->name('student.profile.personal-details');
```

---

#### **Pages/Tutor/ManageSessions/ManageSubjects.php**

- **Clase:** `app/Livewire/Pages/Tutor/ManageSessions/ManageSubjects.php`
- **Vista:** `resources/views/livewire/pages/tutor/manage-sessions/manage-subjects.blade.php`
- **Propósito:** Gestionar materias y horarios del tutor
- **Funcionalidades:**
  - Agregar/eliminar materias
  - Configurar horarios disponibles
  - Establecer precios por materia

**Ruta asociada:**

```php
Route::get('tutor/bookings/manage-subjects', ManageSubjects::class)
    ->name('tutor.bookings.subjects');
```

---

#### **TutorReviews.php**

- **Clase:** `app/Livewire/TutorReviews.php`
- **Vista:** `resources/views/livewire/tutor-reviews.blade.php`
- **Propósito:** Mostrar reseñas de un tutor
- **Funcionalidades:**
  - Listar reseñas
  - Mostrar promedio de calificación
  - Filtrar reseñas

---

#### **Frontend/Checkout.php**

- **Clase:** `app/Livewire/Frontend/Checkout.php`
- **Vista:** `resources/views/livewire/frontend/checkout.blade.php`
- **Propósito:** Proceso de pago
- **Funcionalidades:**
  - Resumen de la compra
  - Aplicar cupones
  - Seleccionar método de pago
  - Procesar pago

**Ruta asociada:**

```php
Route::middleware('student')->get('checkout', Checkout::class)->name('checkout');
```

---

## 🛣️ Rutas

### 📂 Archivos de Rutas

```
routes/
├── web.php                       # Rutas web principales
├── api.php                       # Rutas API REST
├── admin.php                     # Rutas administrativas
├── auth.php                      # Rutas de autenticación
├── pagebuilder.php               # Constructor de páginas
└── optionbuilder.php             # Constructor de opciones
```

### 🌐 Rutas Web Principales (web.php)

#### **Rutas Públicas**

```php
// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');

// Páginas institucionales
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
Route::view('/como-trabajamos', 'vistas.view.pages.trabajamos')->name('como-trabajamos');
Route::view('/preguntas', 'vistas.view.pages.preguntas')->name('preguntas');
Route::view('/terminos', 'vistas.view.pages.terminos')->name('terminos');

// Búsqueda de tutores
Route::get('/tutors', [HomeController::class, 'buscarTutor'])->name('buscar.tutor');
Route::get('/tutores/{slug}', [HomeController::class, 'tutor'])->name('tutor');

// Blog
Route::get('/blogs', [BeforeBlogsController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog:slug}', [BeforeBlogsController::class, 'showBySlug'])->name('blogs.show');

// Promociones
Route::get('/promociones', [PromocionesController::class, 'index'])->name('promociones');
```

---

#### **Rutas Autenticadas**

```php
Route::middleware(['auth', 'verified', 'onlineUser'])->group(function () {

    // Cerrar sesión
    Route::get('logout', [SiteController::class, 'logout'])->name('logout');

    // Favoritos
    Route::post('favourite-tutor', [SearchController::class, 'favouriteTutor'])
        ->name('favourite-tutor');

    // Checkout (solo estudiantes)
    Route::middleware('student')->get('checkout', Checkout::class)->name('checkout');
    Route::middleware('student')->get('thank-you/{id}', ThankYou::class)->name('thank-you');
});
```

---

#### **Rutas de Tutores**

```php
Route::middleware('role:tutor')->prefix('tutor')->name('tutor.')->group(function () {

    // Dashboard
    Route::get('dashboard', ManageAccount::class)->name('dashboard');

    // Perfil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('personal-details', PersonalDetails::class)->name('personal-details');
        Route::get('account-settings', AccountSettings::class)->name('account-settings');
        Route::get('identification', IdentityVerification::class)->name('identification');

        // Currículum
        Route::prefix('resume')->name('resume.')->group(function () {
            Route::get('education', Resume::class)->name('education');
            Route::get('experience', Resume::class)->name('experience');
            Route::get('certificate', Resume::class)->name('certificate');
        });
    });

    // Reservas
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('manage-subjects', ManageSubjects::class)->name('subjects');
        Route::get('manage-sessions', MyCalendar::class)->name('manage-sessions');
        Route::get('session-detail/{date}', SessionDetail::class)->name('session-detail');
        Route::get('upcoming-bookings', UserBooking::class)->name('upcoming-bookings');
    });

    // Pagos
    Route::get('payouts', Payouts::class)->name('payouts');
    Route::get('invoices', Invoices::class)->name('invoices');

    // Disputas
    Route::get('disputes', Dispute::class)->name('disputes');
    Route::get('manage-dispute/{id}', ManageDispute::class)->name('manage-dispute');
});
```

---

#### **Rutas de Estudiantes**

```php
Route::middleware('student')->prefix('student')->name('student.')->group(function () {

    // Perfil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('personal-details', PersonalDetails::class)->name('personal-details');
        Route::get('account-settings', AccountSettings::class)->name('account-settings');
        Route::get('identification', IdentityVerification::class)->name('identification');
    });

    // Reservas
    Route::get('bookings', UserBooking::class)->name('bookings');
    Route::get('reschedule-session/{id}', RescheduleSession::class)->name('reschedule-session');
    Route::get('complete-booking/{id}', [SiteController::class, 'completeBooking'])
        ->name('complete-booking');

    // Favoritos
    Route::get('favourites', Favourites::class)->name('favourites');

    // Facturas
    Route::get('invoices', Invoices::class)->name('invoices');

    // Certificados
    Route::get('certificates', CertificateList::class)->name('certificate-list');

    // Disputas
    Route::get('disputes', Dispute::class)->name('disputes');
    Route::get('manage-dispute/{id}', ManageDispute::class)->name('manage-dispute');
});
```

---

### 🔌 Rutas API (api.php)

#### **Autenticación**

```php
// Públicas
POST /api/login                    # Iniciar sesión
POST /api/register                 # Registrar usuario
POST /api/forget-password          # Recuperar contraseña
POST /api/update-fcm-token         # Token de notificaciones
GET  /api/verify-email             # Verificar email

// Autenticadas
POST /api/logout                   # Cerrar sesión
POST /api/reset-password           # Cambiar contraseña
GET  /api/resend-email             # Reenviar email de verificación
```

---

#### **Tutores**

```php
// Públicas
GET  /api/find-tutors              # Buscar tutores
GET  /api/verified-tutors          # Tutores verificados
GET  /api/available-tutors         # Tutores disponibles ahora
GET  /api/tutor/{slug}             # Detalle de tutor
GET  /api/tutor-available-slots    # Horarios disponibles
GET  /api/tutor/{id}/available-slots # Slots de un tutor
GET  /api/tutor/{id}/instant-slots # Slots instantáneos

// Autenticadas
PUT  /api/user/{id}/tutoring-availability # Cambiar disponibilidad
```

---

#### **Reservas**

```php
// Autenticadas
GET  /api/upcoming-bookings        # Próximas reservas
GET  /api/user/{id}/bookings       # Reservas de un usuario
POST /api/slot-bookings            # Crear reserva
POST /api/test-payment-upload      # Subir comprobante

// Cambio de estado
POST /api/booking/change-to-cursando  # Marcar como "Cursando"
POST /api/booking/change-to-aceptado  # Marcar como "Aceptado"
```

---

#### **Materias de Tutores**

```php
// Gestión de materias
GET    /api/tutor-subjects         # Listar materias del tutor
POST   /api/tutor-subjects         # Agregar materia
PUT    /api/tutor-subjects/{id}    # Actualizar materia
DELETE /api/tutor/{tutor_id}/subjects/{subject_id} # Eliminar materia

// Consultas
GET /api/tutor-subjects/groups     # Grupos de materias
GET /api/tutor-subjects/groups/{groupId}/subjects # Materias por grupo
GET /api/tutor-subjects/available  # Materias disponibles
```

---

#### **Reseñas**

```php
GET    /api/reviews                # Listar reseñas
GET    /api/reviews/received       # Reseñas recibidas
GET    /api/reviews/given          # Reseñas dadas
POST   /api/reviews                # Crear reseña
GET    /api/reviews/{id}           # Ver reseña
PUT    /api/reviews/{id}           # Actualizar reseña
DELETE /api/reviews/{id}           # Eliminar reseña
GET    /api/reviews/stats/{userId} # Estadísticas
```

---

#### **Perfil**

```php
// Autenticadas
GET  /api/profile-settings/{id}    # Obtener perfil
POST /api/profile-settings/{id}    # Actualizar perfil
GET  /api/user/{id}/profile-image  # Obtener foto
POST /api/user/{id}/profile-image  # Actualizar foto
POST /api/user/{id}/profile-files  # Actualizar archivos
PUT  /api/user/{id}/profile        # Actualizar datos
POST /api/user/{id}/profile-price  # Actualizar precio
```

---

#### **Educación, Experiencia y Certificados**

```php
// Educación
GET    /api/tutor-education/{id}   # Ver educación
POST   /api/tutor-education        # Agregar educación
PUT    /api/tutor-education/{id}   # Actualizar educación
DELETE /api/tutor-education/{id}   # Eliminar educación

// Experiencia
GET    /api/tutor-experience/{id}  # Ver experiencia
POST   /api/tutor-experience       # Agregar experiencia
PUT    /api/tutor-experience/{id}  # Actualizar experiencia
DELETE /api/tutor-experience/{id}  # Eliminar experiencia

// Certificados
GET    /api/tutor-certification/{id} # Ver certificado
POST   /api/tutor-certification    # Agregar certificado
DELETE /api/tutor-certification/{id} # Eliminar certificado
```

---

#### **Pagos y Cupones**

```php
// Cupones
GET /api/user-coupons              # Cupones del usuario
GET /api/user-coupons/{id}         # Ver cupón
PUT /api/user-coupons/update-quantity # Actualizar cantidad

// Métodos de pago QR
GET    /api/qr-payout-methods/{user_id} # Listar métodos
POST   /api/qr-payout-methods      # Agregar método
GET    /api/qr-payout-methods/{user_id}/{id} # Ver método
POST   /api/qr-payout-methods/{user_id}/update # Actualizar método
DELETE /api/qr-payout-methods/{user_id} # Eliminar método

// Pagos a tutores
GET  /api/tutor-payouts/{id}       # Historial de pagos
GET  /api/my-earning/{id}          # Ganancias
POST /api/user-withdrawal          # Solicitar retiro
```

---

#### **Google Calendar y Meet**

```php
// Autenticación Google
GET  /api/auth/google/url          # URL de autenticación
POST /api/auth/google/callback     # Callback de Google
POST /api/auth/google/disconnect   # Desconectar Google

// Google Calendar
GET    /api/google-calendar/auth-url # URL de autorización
POST   /api/google-calendar/connect  # Conectar calendario
GET    /api/google-calendar/status   # Estado de conexión
POST   /api/google-calendar/events   # Crear evento
DELETE /api/google-calendar/events/{eventId} # Eliminar evento
POST   /api/google-calendar/disconnect # Desconectar
```

---

#### **Otros Endpoints**

```php
// Taxonomías
GET /api/countries                 # Países
GET /api/states                    # Estados/provincias
GET /api/languages                 # Idiomas
GET /api/subject-groups            # Grupos de materias
GET /api/subjects                  # Materias
GET /api/all-subjects              # Todas las materias

// Configuraciones
GET /api/settings                  # Configuraciones del sitio

// Alianzas
GET /api/alianzas                  # Alianzas/partners
```

---

## 🔧 Servicios

### 📂 Ubicación

`app/Services/`

Los servicios encapsulan lógica de negocio compleja que no pertenece a controladores o modelos.

### 🔑 Servicios Principales

#### **GoogleMeetService.php**

- **Ruta:** `app/Services/GoogleMeetService.php`
- **Propósito:** Integración con Google Meet
- **Métodos:**
  - `createMeeting()`: Crear reunión de Google Meet
  - `updateMeeting()`: Actualizar reunión
  - `deleteMeeting()`: Eliminar reunión

---

## 📝 Relaciones MVC Completas

### Ejemplo 1: Sistema de Reservas

**Flujo completo:**

1. **Usuario visita:** `/tutors` (Buscar tutores)

   - **Ruta:** `Route::get('/tutors', [HomeController::class, 'buscarTutor'])`
   - **Controlador:** `HomeController@buscarTutor`
   - **Vista:** `resources/views/vistas/view/pages/buscar.blade.php`
   - **Componente Livewire:** `BuscarTutor.php`

2. **Usuario selecciona tutor:** `/tutores/{slug}`

   - **Ruta:** `Route::get('/tutores/{slug}', [HomeController::class, 'tutor'])`
   - **Controlador:** `HomeController@tutor`
   - **Modelo:** `User::where('slug', $slug)->first()`
   - **Vista:** `resources/views/frontend/tutor-detail.blade.php`
   - **Componentes:** `TutorReviews.php`, `Reserva.php`

3. **Usuario hace reserva:** Componente Livewire `Reserva.php`

   - **Modelo:** `SlotBooking::create()`
   - **Relaciones:** `User`, `Subject`, `UserSubject`
   - **Servicio:** `GoogleMeetService::createMeeting()`

4. **Usuario paga:** `/checkout`

   - **Ruta:** `Route::get('checkout', Checkout::class)`
   - **Componente Livewire:** `Frontend/Checkout.php`
   - **Modelo:** `PaymentSlotBooking::create()`

5. **Confirmación:** `/thank-you/{id}`
   - **Ruta:** `Route::get('thank-you/{id}', ThankYou::class)`
   - **Componente Livewire:** `Frontend/ThankYou.php`
   - **Email:** `emails/session-booking.blade.php`

---

### Ejemplo 2: Gestión de Materias del Tutor

**Flujo completo:**

1. **Tutor accede:** `/tutor/bookings/manage-subjects`

   - **Ruta:** `Route::get('tutor/bookings/manage-subjects', ManageSubjects::class)`
   - **Componente Livewire:** `Pages/Tutor/ManageSessions/ManageSubjects.php`
   - **Vista:** `livewire/pages/tutor/manage-sessions/manage-subjects.blade.php`

2. **Tutor agrega materia:** Método `addSubject()` en Livewire

   - **Modelo:** `UserSubject::create()`
   - **Relaciones:** `User`, `Subject`

3. **Tutor configura horarios:** Método `addSlot()` en Livewire

   - **Modelo:** `UserSubjectSlot::create()`
   - **Relación:** `UserSubject`

4. **API móvil consulta:** `GET /api/tutor-subjects`
   - **Ruta:** `Route::apiResource('tutor-subjects', UserSubjectController::class)`
   - **Controlador:** `Api/UserSubjectController@index`
   - **Modelo:** `UserSubject::with('subject', 'slots')->get()`

---

### Ejemplo 3: Sistema de Reseñas

**Flujo completo:**

1. **Estudiante escribe reseña:** `/tutores/{slug}` (formulario en detalle de tutor)

   - **Ruta:** `Route::post('/tutor/{tutorId}/review', [HomeController::class, 'storeReview'])`
   - **Controlador:** `HomeController@storeReview`
   - **Modelo:** `Review::create()`
   - **Relaciones:** `User` (reviewer), `User` (reviewed), `SlotBooking`

2. **Mostrar reseñas:** Componente Livewire `TutorReviews.php`

   - **Modelo:** `Review::where('reviewed_id', $tutorId)->get()`
   - **Vista:** `livewire/tutor-reviews.blade.php`

3. **API móvil consulta:** `GET /api/reviews/received`

   - **Ruta:** `Route::get('reviews/received', [ReviewController::class, 'getReceivedReviews'])`
   - **Controlador:** `Api/ReviewController@getReceivedReviews`
   - **Modelo:** `Review::where('reviewed_id', auth()->id())->get()`

4. **Estadísticas:** `GET /api/reviews/stats/{userId}`
   - **Controlador:** `Api/ReviewController@getStats`
   - **Cálculos:** Promedio de rating, total de reseñas

---

## 📊 Diagrama de Arquitectura

```
┌─────────────────────────────────────────────────────────────┐
│                        FRONTEND                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │ Blade Views  │  │   Livewire   │  │  JavaScript  │      │
│  │  Templates   │  │  Components  │  │   (Alpine)   │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                        RUTAS                                 │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │   web.php    │  │   api.php    │  │  admin.php   │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                     CONTROLADORES                            │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │     Web      │  │     API      │  │    Admin     │      │
│  │ Controllers  │  │ Controllers  │  │ Controllers  │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                  SERVICIOS / LÓGICA                          │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │   Services   │  │     Jobs     │  │    Events    │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                       MODELOS                                │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │     User     │  │ SlotBooking  │  │    Review    │      │
│  │    Subject   │  │ UserSubject  │  │    Order     │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                    BASE DE DATOS                             │
│                      MySQL / MariaDB                         │
└─────────────────────────────────────────────────────────────┘
```

---

## 🎓 Guía para Nuevos Pasantes

### Primeros Pasos

1. **Familiarízate con Laravel:**

   - Documentación oficial: https://laravel.com/docs
   - Entiende el patrón MVC
   - Aprende sobre Eloquent ORM

2. **Entiende Livewire:**

   - Documentación: https://livewire.laravel.com
   - Componentes reactivos sin JavaScript
   - Ciclo de vida de componentes

3. **Explora el proyecto:**
   - Revisa la estructura de carpetas
   - Lee los archivos de rutas (`routes/`)
   - Examina los modelos principales

### Flujo de Trabajo Típico

**Para agregar una nueva funcionalidad:**

1. **Crear ruta** en `routes/web.php` o `routes/api.php`
2. **Crear controlador** en `app/Http/Controllers/`
3. **Crear/modificar modelo** en `app/Models/`
4. **Crear vista** en `resources/views/`
5. **Crear componente Livewire** (si es necesario) en `app/Livewire/`

### Comandos Útiles

```bash
# Ver rutas
php artisan route:list

# Crear controlador
php artisan make:controller NombreController

# Crear modelo con migración
php artisan make:model NombreModelo -m

# Crear componente Livewire
php artisan make:livewire NombreComponente

# Ejecutar migraciones
php artisan migrate

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Convenciones del Proyecto

- **Nombres de archivos:** PascalCase para clases, kebab-case para vistas
- **Rutas:** Usar nombres descriptivos con `->name()`
- **Modelos:** Singular (User, Review)
- **Tablas:** Plural (users, reviews)
- **Controladores:** Sufijo `Controller` (UserController)
- **Livewire:** Organizar por funcionalidad en subcarpetas

---

## 📞 Contacto y Soporte

Para dudas sobre el proyecto, contactar al equipo de desarrollo.

---

**Fin de la documentación**
