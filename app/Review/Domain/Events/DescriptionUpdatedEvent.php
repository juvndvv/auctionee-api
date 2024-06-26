<?php

namespace App\Review\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class DescriptionUpdatedEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $reviewedUuid, array $payload, string $occurredOn, string $eventId = null)
    {
        parent::__construct($occurredOn, $payload, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return ['admin', 'users', 'user.' . $this->reviewedUuid];
    }

    public function broadcastAs(): string
    {
        return DescriptionUpdatedEvent::eventName();
    }

    public static function eventName(): string
    {
        return 'review.description.updated';
    }
}
