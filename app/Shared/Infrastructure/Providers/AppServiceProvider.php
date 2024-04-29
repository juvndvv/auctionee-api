<?php

namespace App\Shared\Infrastructure\Providers;

use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Infrastructure\Repositories\TransactionEloquentRepository;
use App\Financial\Infrastructure\Repositories\WalletEloquentRepository;
use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;
use App\Retention\Email\Domain\Ports\Outbound\EmailSenderPort;
use App\Retention\Email\Infrastructure\EmailSender\ResendEmailSender;
use App\Retention\Email\Infrastructure\Repositories\InMemoryEmailRepository;
use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Retention\EventMonitoring\Infrastructure\Repositories\EloquentEventRepository;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Infrastructure\Repositories\ReviewEloquentRepository;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infrastructure\Listeners\UserBlockedListener;
use App\Shared\Infrastructure\Listeners\UserCreatedListener;
use App\Shared\Infrastructure\Listeners\UserDeletedListener;
use App\Shared\Infrastructure\Listeners\UserUnblockedListener;
use App\Shared\Infrastructure\Listeners\UserUpdatedListener;
use App\Shared\Infrastructure\Repositories\ImageCloudfareR2Repository;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Domain\Ports\FriendshipRepositoryPort;
use App\Social\Infrastructure\Repositories\ChatMessagesEloquentRepository;
use App\Social\Infrastructure\Repositories\ChatRoomEloquentRepository;
use App\Social\Infrastructure\Repositories\FriendshipEloquentRepository;
use App\User\Domain\Events\UserBlockedEvent;
use App\User\Domain\Events\UserCreatedEvent;
use App\User\Domain\Events\UserDeletedEvent;
use App\User\Domain\Events\UserUnblockedEvent;
use App\User\Domain\Events\UserUpdatedEvent;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Infrastructure\Repositories\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected array $listen = [
        UserCreatedEvent::class => [
            UserCreatedListener::class
        ],
        UserDeletedEvent::class => [
            UserDeletedListener::class
        ],
        UserUpdatedEvent::class => [
            UserUpdatedListener::class
        ],
        UserBlockedEvent::class => [
            UserBlockedListener::class
        ],
        UserUnblockedEvent::class => [
            UserUnblockedListener::class
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
