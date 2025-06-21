<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Schedule;
use Illuminate\Console\Scheduling\Schedule as ConsoleSchedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('payment', [
            \App\Http\Middleware\Payment::class
        ]);
        $middleware->group('waiting_room', [
            \App\Http\Middleware\WaitingRoomMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // You can customize exception handling here
    })
    ->withSchedule(function (Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('app:update-control-status')->everyMinute();
    })
    
    ->create();
