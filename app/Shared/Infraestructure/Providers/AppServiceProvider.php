<?php

namespace App\Shared\Infraestructure\Providers;

use App\Auction\Application\Services\AuctionService;
use App\Auction\Domain\Ports\Inbound\AuctionServicePort;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Infraestructure\Repositories\EloquentAuctionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuctionRepositoryPort::class, EloquentAuctionRepository::class);
        $this->app->singleton(AuctionServicePort::class, AuctionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
