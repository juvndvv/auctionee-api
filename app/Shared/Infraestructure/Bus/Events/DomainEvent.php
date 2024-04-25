<?php

declare(strict_types=1);

namespace App\Shared\Infraestructure\Bus\Events;

use App\Shared\Domain\Models\ValueObjects\Uuid;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

abstract class DomainEvent implements ShouldBroadcastNow
{
    public $eventId;
    public $message;
    public $eventType;
    public $ocurredOn;

    public function __construct(string $ocurredOn, array $message, string $eventType, string $eventId = null)
    {
        $this->ocurredOn = $ocurredOn;
        $this->message = $message;
        $this->eventType = $eventType;
        $this->eventId = $eventId ?: Uuid::random()->value();
    }

    abstract public function broadcastOn(): array;

    abstract public function broadcastAs(): string;

    abstract public static function eventName(): string;
}
