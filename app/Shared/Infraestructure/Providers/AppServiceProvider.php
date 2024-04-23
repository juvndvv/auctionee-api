<?php

namespace App\Shared\Infraestructure\Providers;

use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;
use App\Retention\Email\Domain\Ports\Outbound\EmailSenderPort;
use App\Retention\Email\Infraestructure\EmailSender\ResendEmailSender;
use App\Retention\Email\Infraestructure\Repositories\InMemoryEmailRepository;
use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Retention\EventMonitoring\Infraestructure\Repositories\EloquentEventRepository;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Infraestructure\Repositories\ReviewEloquentRepository;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infraestructure\Listeners\UserCreatedListener;
use App\Shared\Infraestructure\Repositories\ImageCloudfareR2Repository;
use App\UserManagement\Domain\Events\UserCreatedEvent;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Infraestructure\Repositories\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $listen = [
        UserCreatedEvent::class => [
            UserCreatedListener::class
        ]
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryPort::class, UserEloquentRepository::class);
        $this->app->singleton(ImageRepositoryPort::class, ImageCloudfareR2Repository::class);
        $this->app->singleton(EmailRepositoryPort::class, InMemoryEmailRepository::class);
        $this->app->singleton(EmailSenderPort::class, ResendEmailSender::class);
        $this->app->singleton(ReviewRepositoryPort::class, ReviewEloquentRepository::class);
        $this->app->singleton(EventRepositoryPort::class, EloquentEventRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
