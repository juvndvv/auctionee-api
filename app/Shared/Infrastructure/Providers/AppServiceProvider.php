<?php

namespace App\Shared\Infrastructure\Providers;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Domain\Ports\Outbound\BidRepositoryPort;
use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Auction\Infrastructure\Repositories\EloquentAuctionRepository;
use App\Auction\Infrastructure\Repositories\EloquentBidRepository;
use App\Auction\Infrastructure\Repositories\EloquentCategoryRepository;
use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Infrastructure\Repositories\EloquentTransactionRepository;
use App\Financial\Infrastructure\Repositories\EloquentWalletRepository;
use App\Retention\Email\Domain\Ports\Outbound\EmailRepositoryPort;
use App\Retention\Email\Domain\Ports\Outbound\EmailSenderPort;
use App\Retention\Email\Infrastructure\EmailSender\ResendEmailSender;
use App\Retention\Email\Infrastructure\Repositories\InMemoryEmailRepository;
use App\Retention\EventMonitoring\Domain\Ports\Outbound\EventRepositoryPort;
use App\Retention\EventMonitoring\Infrastructure\Repositories\EloquentEventRepository;
use App\Review\Domain\Ports\Outbound\ReviewRepositoryPort;
use App\Review\Infrastructure\Repositories\EloquentReviewRepository;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infrastructure\Listeners\UserBlockedListener;
use App\Shared\Infrastructure\Listeners\UserCreatedListener;
use App\Shared\Infrastructure\Listeners\UserDeletedListener;
use App\Shared\Infrastructure\Listeners\UserUnblockedListener;
use App\Shared\Infrastructure\Listeners\UserUpdatedListener;
use App\Shared\Infrastructure\Repositories\CloudflareR2ImageRepository;
use App\Social\Domain\Ports\ChatMessagesRepositoryPort;
use App\Social\Domain\Ports\ChatRoomRepositoryPort;
use App\Social\Infrastructure\Repositories\EloquentChatMessagesRepository;
use App\Social\Infrastructure\Repositories\EloquentChatRoomRepository;
use App\User\Domain\Events\UserBlockedEvent;
use App\User\Domain\Events\UserCreatedEvent;
use App\User\Domain\Events\UserDeletedEvent;
use App\User\Domain\Events\UserUnblockedEvent;
use App\User\Domain\Events\UserUpdatedEvent;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;
use App\User\Infrastructure\Repositories\EloquentUserRepository;
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
        $this->app->bind(UserRepositoryPort::class, EloquentUserRepository::class);
        $this->app->bind(ImageRepositoryPort::class, CloudflareR2ImageRepository::class);
        $this->app->bind(EmailRepositoryPort::class, InMemoryEmailRepository::class);
        $this->app->bind(EmailSenderPort::class, ResendEmailSender::class);
        $this->app->bind(ReviewRepositoryPort::class, EloquentReviewRepository::class);
        $this->app->bind(EventRepositoryPort::class, EloquentEventRepository::class);
        $this->app->bind(WalletRepositoryPort::class, EloquentWalletRepository::class);
        $this->app->bind(TransactionRepositoryPort::class, EloquentTransactionRepository::class);
        $this->app->bind(ChatRoomRepositoryPort::class, EloquentChatRoomRepository::class);
        $this->app->bind(ChatMessagesRepositoryPort::class, EloquentChatMessagesRepository::class);
        $this->app->bind(CategoryRepositoryPort::class, EloquentCategoryRepository::class);
        $this->app->bind(AuctionRepositoryPort::class, EloquentAuctionRepository::class);
        $this->app->bind(BidRepositoryPort::class, EloquentBidRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
