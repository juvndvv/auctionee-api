<?php

namespace App\Social\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private readonly string $destinationUuid;

    public function __construct(string $destinationUuid, array $payload, string $ocuredOn, string $eventId = null)
    {
        parent::__construct($ocuredOn, $payload, self::eventName(), $eventId);
        $this->destinationUuid = $destinationUuid;
    }

    public function broadcastOn(): array
    {
        return ['user.' . $this->destinationUuid];
    }

    public function broadcastAs(): string
    {
        return self::eventName();
    }

    public static function eventName(): string
    {
        return 'message.received';
    }
}
