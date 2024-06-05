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
            $auctions = DB::select('
            SELECT *
            FROM auctions
            WHERE
                NOT finished
                AND DATE_ADD(NOW(), INTERVAL 2 HOUR) > DATE_ADD(auctions.starting_date, INTERVAL auctions.duration MINUTE)
                '
            );

            foreach ($auctions as $auction) {
                DB::update(
                    'UPDATE auctions
                    SET finished = 1'
                );
            }
        })->everyFiveMinutes();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
