<?php

namespace App\Social\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class FriendRequestCreatedEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly string $receiverUuid,
        array $payload,
        string $occurredOn,
        string $eventId = null)
    {
        parent::__construct($occurredOn, $payload, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return ['user.' . $this->receiverUuid];
    }

    public function broadcastAs(): string
    {
        return self::eventName();
    }

    public static function eventName(): string
    {
        return 'friendship.created';
    }
}
