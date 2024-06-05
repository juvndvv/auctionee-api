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
            EloquentAuctionModel::query()
                ->where('finished', '=', '0')
                ->each(function($auction) {
                    $auction->update(['finished' => true]);
                });
        })->everySecond();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
