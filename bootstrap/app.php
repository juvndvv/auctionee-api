<?php

use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\DB;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../app/Shared/Infrastructure/Http/Routes/api.php',
        health: '/up',
    )
    ->withEvents(discover: [
        __DIR__.'/../app/Shared/Infrastructure/Listeners',
    ])
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function() {
            DB::update('UPDATE auctions SET FINISHED = 1 WHERE FINISHED = 0');

        })->everySecond();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
