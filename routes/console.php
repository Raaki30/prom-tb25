<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\UpdateControlStatus;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('app:update-control-status', function () {
    app(UpdateControlStatus::class)->handle();
})->purpose('Update status kontrol berdasarkan tanggal mulai dan berakhir');