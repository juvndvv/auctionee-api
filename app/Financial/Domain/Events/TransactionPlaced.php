<?php

namespace App\Financial\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionPlaced extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(array $message, string $ocurredOn, string $eventId = null)
    {
        parent::__construct($ocurredOn, $message, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return [TransactionPlaced::eventName()];
    }

    public function broadcastAs(): string
    {
        return TransactionPlaced::eventName();
    }

    public static function eventName(): string
    {
        return 'transaction-placed';
    }
}
