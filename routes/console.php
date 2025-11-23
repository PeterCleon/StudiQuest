<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule untuk daily challenges
Schedule::call(function () {
    Artisan::call('challenges:generate-daily');
})->dailyAt('00:01');

// Untuk testing di local:
// Schedule::call(function () {
//     Artisan::call('challenges:generate-daily');
// })->everyMinute();