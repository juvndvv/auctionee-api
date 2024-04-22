<?php

namespace App\UserManagement\Domain\Events;

use App\Shared\Domain\Bus\Events\DomainEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserBlockedEvent extends DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $uuid, string $ocurredOn, string $eventId = null)
    {
        parent::__construct($ocurredOn, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return [UserBlockedEvent::eventName()];
    }

    public function broadcastAs(): string
    {
        return UserBlockedEvent::eventName();
    }

    public static function eventName(): string
    {
        return 'user-blocked';
    }
}
