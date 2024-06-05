<?php

namespace App\Financial\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class TransactionPlacedEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(private readonly string $userUuid, array $payload, string $occurredOn, string $eventId = null)
    {
        parent::__construct($occurredOn, $payload, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return ['transactions', 'user.' . $this->userUuid];
    }

    public function broadcastAs(): string
    {
        return TransactionPlacedEvent::eventName();
    }

    public static function eventName(): string
    {
        return 'transaction.placed';
    }
}
