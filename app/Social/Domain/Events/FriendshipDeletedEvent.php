<?php

namespace App\Social\Domain\Events;

use App\Shared\Infraestructure\Bus\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendshipDeletedEvent extends DomainEvent
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
        return 'friendship.deleted';
    }
}