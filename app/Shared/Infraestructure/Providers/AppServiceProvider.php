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
use App\Authentication\Application\RegisterUserUseCase;
use App\Authentication\Domain\Ports\Inbound\RegisterUserUseCasePort;
use App\Authentication\Domain\Ports\Outbound\AuthRepositoryPort;
use App\Authentication\Infraestructure\Repositories\EloquentAuthRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuctionRepositoryPort::class, EloquentAuctionRepository::class);
        $this->app->singleton(CreateAuctionUseCasePort::class, CreateAuctionUseCase::class);
        $this->app->singleton(DeleteAuctionByIdUseCasePort::class, DeleteAuctionByIdUseCase::class);
        $this->app->singleton(FindAllAuctionUseCasePort::class, FindAllAuctionUseCase::class);
        $this->app->singleton(FindAuctionByIdUseCasePort::class, FindAuctionByIdUseCase::class);

        $this->app->singleton(AuthRepositoryPort::class, EloquentAuthRepository::class);
        $this->app->singleton(RegisterUserUseCasePort::class, RegisterUserUseCase::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
