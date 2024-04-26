<?php

namespace App\Shared\Infraestructure\Providers;

use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Infraestructure\Repositories\TransactionEloquentRepository;
use App\Financial\Infraestructure\Repositories\WalletEloquentRepository;
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
use App\Shared\Infraestructure\Listeners\UserDeletedListener;
use App\Shared\Infraestructure\Repositories\ImageCloudfareR2Repository;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Domain\Ports\FriendshipRepositoryPort;
use App\Social\Infraestructure\Repositories\ChatMessagesEloquentRepository;
use App\Social\Infraestructure\Repositories\ChatRoomEloquentRepository;
use App\Social\Infraestructure\Repositories\FriendshipEloquentRepository;
use App\UserManagement\Domain\Events\UserCreatedEvent;
use App\UserManagement\Domain\Events\UserDeletedEvent;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Infraestructure\Repositories\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreatedEvent::class => [
            UserCreatedListener::class
        ],
        UserDeletedEvent::class => [
            UserDeletedListener::class
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
        $this->app->singleton(WalletRepositoryPort::class, WalletEloquentRepository::class);
        $this->app->singleton(TransactionRepositoryPort::class, TransactionEloquentRepository::class);
        $this->app->singleton(ChatRoomRepositoryPort::class, ChatRoomEloquentRepository::class);
        $this->app->singleton(ChatMessagesRepositoryPort::class, ChatMessagesEloquentRepository::class);
        $this->app->singleton(FriendshipRepositoryPort::class, FriendshipEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
