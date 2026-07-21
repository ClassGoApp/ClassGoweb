<?php

use App\Http\Controllers\Admin\GeneralController;
use App\Livewire\Pages\Admin\Blogs\BlogCategories;
use App\Livewire\Pages\Admin\Blogs\Blogs;
use App\Livewire\Pages\Admin\Blogs\CreateBlog;
use App\Livewire\Pages\Admin\Blogs\UpdateBlog;
use App\Livewire\Pages\Admin\Bookings\Bookings;
use App\Livewire\Pages\Admin\CoursesCompany\Courses;
use App\Livewire\Pages\Admin\Dispute\Dispute;
use App\Livewire\Pages\Admin\Dispute\ManageDispute;
use App\Livewire\Pages\Admin\EmailTemplates\EmailTemplates;
use App\Livewire\Pages\Admin\Encuestas\Encuestas;
use App\Livewire\Pages\Admin\IdentityVerification\IdentityVerification;
use App\Livewire\Pages\Admin\Insights\Insights;
use App\Livewire\Pages\Admin\Invoices\Invoices;
use App\Livewire\Pages\Admin\Menu\ManageMenu;
use App\Livewire\Pages\Admin\Packages\ManagePackages;
use App\Livewire\Pages\Admin\Packages\InstalledPackages;
use App\Livewire\Pages\Admin\Payments\CommissionSettings;
use App\Livewire\Pages\Admin\Payments\PaymentMethods;
use App\Livewire\Pages\Admin\Payments\WithdrawRequest;
use App\Livewire\Pages\Admin\Profile\AdminProfile;
use App\Livewire\Pages\Admin\Taxonomy\Languages;
use App\Livewire\Pages\Admin\Taxonomy\SubjectGroups;
use App\Livewire\Pages\Admin\Taxonomy\Subjects;
use App\Livewire\Pages\Admin\Upgrade\Upgrade;
use App\Livewire\Pages\Admin\Users\Users;
use App\Livewire\Pages\Admin\Users\UsersReports;
use App\Http\Controllers\Admin\AlianzaController;
use App\Livewire\Pages\Admin\Alianzas\Alianzas as AlianzasListing;
use App\Livewire\Pages\Admin\Alianzas\CreateAlianza;
use App\Livewire\Pages\Admin\Alianzas\UpdateAlianza;
use App\Livewire\Pages\Admin\Team\Team as TeamListing;
use App\Livewire\Pages\Admin\Team\CreateTeam;
use App\Livewire\Pages\Admin\Team\UpdateTeam;
use App\Http\Controllers\Admin\SlotBookingAdminController;
use App\Http\Controllers\Admin\TutorController;
use App\Livewire\Admin\Tutors\Tutors;
use App\Livewire\Promociones\Cupones;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/insights', Insights::class)->name('insights');
    Route::get('/profile', AdminProfile::class)->name('profile');
    Route::get('/manage-menus', ManageMenu::class)->name('manage-menus');
    
    Route::get('/blogs', Blogs::class)->name('blog-listing');
    Route::get('/blogs/create', CreateBlog::class)->name('create-blog');
    Route::get('/blogs/update/{id}', UpdateBlog::class)->name('update-blog');
    Route::get('/blog-categories', BlogCategories::class)->name('blog-categories');

    // Rutas para Alianzas (Livewire)
    Route::get('/alianzas', AlianzasListing::class)->name('alianzas-listing');
    Route::get('/alianzas/create', CreateAlianza::class)->name('create-alianza');
    Route::get('/alianzas/update/{id}', UpdateAlianza::class)->name('update-alianza');

    // ==========================================
    // NUEVAS RUTAS PARA TEAM (Livewire)
    // ==========================================
    Route::get('/team', TeamListing::class)->name('team-listing');
    Route::get('/team/create', CreateTeam::class)->name('create-team');
    Route::get('/team/update/{id}', UpdateTeam::class)->name('update-team');
    
    Route::prefix('taxonomies')->name('taxonomy.')->group(function () {
        Route::get('languages', Languages::class)->name('languages');
        Route::get('subjects', Subjects::class)->name('subjects');
        Route::get('subject-groups', SubjectGroups::class)->name('subject-groups');
        Route::get('subjects', Subjects::class)->name('subjects');
        Route::get('subject-groups', SubjectGroups::class)->name('subject-groups');
        Route::get('courses', Courses::class)->name('courses');
    });

    Route::get('commission-settings',   CommissionSettings::class)->name('commission-settings');
    Route::get('payment-methods',       PaymentMethods::class)->name('payment-methods');
    Route::get('withdraw-requests',     WithdrawRequest::class)->name('withdraw-requests');

    Route::get('users',          Users::class)->name('users');
    Route::get('users/reports',          UsersReports::class)->name('users-reports');
    Route::get('identity-verification',          IdentityVerification::class)->name('identity-verification');
    Route::get('bookings',          Bookings::class)->name('bookings');
    Route::get('invoices',          Invoices::class)->name('invoices');
    Route::get('email-settings', EmailTemplates::class)->name('email-settings');
    Route::get('users/approve-identity/{id}', [Users::class, 'approveUserIdentity'])->name('approve-user-identity');
    Route::get('upgrade', Upgrade::class)->name('upgrade');
    Route::get('upgrade/logs', [App\Http\Controllers\Admin\GeneralController::class, 'getUpgradeLogs'])->name('upgrade-logs');

    Route::post('update-sass-style',    [App\Http\Controllers\Admin\GeneralController::class, 'updateSaas']);
    Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
        Route::get('', ManagePackages::class)->name('index');
        Route::get('installed', InstalledPackages::class)->name('installed');
        Route::post('upload', [GeneralController::class, 'uploadAddon'])->name('upload');
    });
    Route::get('disputes', Dispute::class)->name('disputes');
    Route::get('manage-dispute/{id}', ManageDispute::class)->name('manage-dispute');
    Route::get('clear-cache', [GeneralController::class, 'clearCache'])->name('clear-cache');
    Route::post('update-smtp-settings', [GeneralController::class, 'updateSMTPSettings'])->name('update-smtp-settings');
    Route::post('update-social-login-settings', [GeneralController::class, 'updateSocialLoginSettings'])->name('update-social-login-settings');

    Route::get('tutorias', [SlotBookingAdminController::class, 'index'])->name('tutorias.index');
    Route::post('tutorias/{id}/status', [SlotBookingAdminController::class, 'updateStatus'])->name('tutorias.updateStatus');
    
    Route::get('/tutors', Tutors::class)->name('tutors.index');
    Route::get('/tutors{tutor}', Tutors::class)->name('tutors.show');

    /**
     * rutas para la gestion de cupones cupones
     */
    Route::get('cupones', Cupones::class)->name('cupones.index');

    /**
     * Rutas para la visualización de la encuesta
     */
    Route::get('encuesta/resumen', \App\Livewire\Pages\Admin\Encuestas\Resumen::class)->name('encuesta-resumen');
    Route::get('encuesta', Encuestas::class)->name('encuesta');
    Route::get('recruitment', \App\Livewire\Pages\Admin\Recruitment\RecruitmentListing::class)->name('recruitment-listing');
    Route::get('notificaciones-push', \App\Livewire\Pages\Admin\Notificaciones\NotificacionesPush::class)->name('notificaciones-push');
    Route::get('notificaciones-email', \App\Livewire\Pages\Admin\Notificaciones\NotificacionesEmail::class)->name('notificaciones-email');
});

