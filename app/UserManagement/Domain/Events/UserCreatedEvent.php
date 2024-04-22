<?php

namespace App\UserManagement\Domain\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $ocurredOn;

    public function __construct($message, $occurredOn)
    {
        $this->message = $message;
        $this->ocurredOn = $occurredOn;
    }

    public function broadcastOn(): array
    {
        return [UserCreatedEvent::eventName()];
    }

    public function broadcastAs(): string
    {
        return UserCreatedEvent::eventName();
    }

    public static function eventName(): string
    {
        return 'user-created';
    }

}
