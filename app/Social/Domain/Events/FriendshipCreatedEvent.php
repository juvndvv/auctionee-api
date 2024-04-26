<?php

namespace App\Social\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendshipCreatedEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(array $message, string $occurredOn, string $eventId = null)
    {
        parent::__construct($occurredOn, $message, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return [self::eventName()];
    }

    public function broadcastAs(): string
    {
        return self::eventName();
    }

    public static function eventName(): string
    {
        return 'friendship.created';
    }

    public static function create(array $message, string $occurredOn, string $eventId = null): self
    {
        return new self($message, $occurredOn, $eventId);
    }
}
