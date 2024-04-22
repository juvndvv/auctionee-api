<?php

namespace App\Shared\Infraestructure\Providers;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Infraestructure\Repositories\EloquentAuctionRepository;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infraestructure\Repositories\ImageCloudfareR2Repository;
use App\UserManagement\Domain\Events\UserCreatedEvent;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Infraestructure\Repositories\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $listen = [
        UserCreatedEvent::class => [
        ]
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuctionRepositoryPort::class, EloquentAuctionRepository::class);
        $this->app->singleton(UserRepositoryPort::class, UserEloquentRepository::class);
        $this->app->singleton(ImageRepositoryPort::class, ImageCloudfareR2Repository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
