<?php

namespace App\Social\Domain\Events;

use App\Shared\Infraestructure\Bus\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDeletedEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private readonly string $destinationUuid;

    public function __construct(string $destinationUuid, array $message, string $ocuredOn, string $eventId = null)
    {
        parent::__construct($ocuredOn, $message, self::eventName(), $eventId);
        $this->destinationUuid = $destinationUuid;
    }

    public function broadcastOn(): array
    {
        return ['messages.' . $this->destinationUuid];
    }

    public function broadcastAs(): string
    {
        return self::eventName();
    }

    public static function eventName(): string
    {
        return 'message.deleted';
    }
}