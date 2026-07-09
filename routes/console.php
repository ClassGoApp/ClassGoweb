<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

use App\Models\User;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('app:complete-slot-bookings', )->everyMinute();
Schedule::command('app:expire-bookings')->everyMinute();

Schedule::command('batches:tick')->everyMinute();

    