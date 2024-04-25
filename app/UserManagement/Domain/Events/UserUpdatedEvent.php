<?php

namespace App\UserManagement\Domain\Events;

use App\Shared\Infraestructure\Bus\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserUpdatedEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(array $message, string $ocurredOn, string $eventId = null)
    {
        parent::__construct($ocurredOn, $message, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return [UserUpdatedEvent::eventName()];
    }

    public function broadcastAs(): string
    {
        return UserUpdatedEvent::eventName();
    }

    public static function eventName(): string
    {
        return 'user-updated';
    }
}
