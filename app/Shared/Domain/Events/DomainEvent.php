<?php

declare(strict_types=1);

namespace App\Shared\Domain\Events;

use App\Shared\Domain\Models\ValueObjects\Uuid;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

abstract class DomainEvent implements ShouldBroadcastNow
{
    public string $eventId;
    public array $payload;
    public string $eventType;
    public string $occurredOn;

    public function __construct(string $occurredOn, array $payload, string $eventType, string $eventId = null)
    {
        $this->occurredOn = $occurredOn;
        $this->payload = $payload;
        $this->eventType = $eventType;
        $this->eventId = $eventId ?: Uuid::random()->value();
    }

    abstract public function broadcastOn(): array;

    abstract public function broadcastAs(): string;

    abstract public static function eventName(): string;

    public static function create(string $occurredOn, array $payload, string $eventType, string $eventId = null): self
    {
        return new static($occurredOn, $payload, $eventType, $eventId);
    }
}
