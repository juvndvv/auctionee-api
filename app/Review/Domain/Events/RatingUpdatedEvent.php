<?php

namespace App\Review\Domain\Events;

use App\Shared\Domain\Bus\Events\DomainEvent;
use App\UserManagement\Domain\Events\UserCreatedEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RatingUpdatedEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(array $message, string $ocurredOn, string $eventId = null)
    {
        parent::__construct($ocurredOn, $message, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return [RatingUpdatedEvent::eventName()];
    }

    public function broadcastAs(): string
    {
        return RatingUpdatedEvent::eventName();
    }

    public static function eventName(): string
    {
        return 'review-rating-updated';
    }
}
