<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:check-task-sla')
    ->everyFiveMinutes()
    ->withoutOverLapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/check_task_sla.log'));