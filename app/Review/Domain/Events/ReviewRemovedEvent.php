<?php

namespace App\Review\Domain\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewRemovedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(array $message, string $ocurredOn, string $eventId = null)
    {
        parent::__construct($ocurredOn, $message, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return [ReviewRemovedEvent::eventName()];
    }

    public function broadcastAs(): string
    {
        return ReviewRemovedEvent::eventName();
    }

    public static function eventName(): string
    {
        return 'review-removed';
    }
}
