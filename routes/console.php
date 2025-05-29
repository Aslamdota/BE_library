<?php

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\UpdateLoanFines;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwalkan command UpdateLoanFines setiap menit
app()->make(Schedule::class)->call(function () {
    Artisan::call('loans:update-fines');
})->everyMinute();
