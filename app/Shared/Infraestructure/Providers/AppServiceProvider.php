<?php

namespace App\Shared\Infraestructure\Providers;

use App\Auction\Application\CreateAuctionUseCase;
use App\Auction\Application\DeleteAuctionByIdUseCase;
use App\Auction\Application\FindAllAuctionUseCase;
use App\Auction\Application\FindAuctionByIdUseCase;
use App\Auction\Application\Services\AuctionService;
use App\Auction\Domain\Ports\Inbound\AuctionServicePort;
use App\Auction\Domain\Ports\Inbound\CreateAuctionUseCasePort;
use App\Auction\Domain\Ports\Inbound\DeleteAuctionByIdUseCasePort;
use App\Auction\Domain\Ports\Inbound\FindAllAuctionUseCasePort;
use App\Auction\Domain\Ports\Inbound\FindAuctionByIdUseCasePort;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Infraestructure\Repositories\EloquentAuctionRepository;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Infraestructure\Repositories\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuctionRepositoryPort::class, EloquentAuctionRepository::class);
        $this->app->singleton(UserRepositoryPort::class, UserEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
