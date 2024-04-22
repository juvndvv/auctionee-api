<?php

namespace App\Shared\Domain\Bus\Events;

use App\Shared\Domain\Models\ValueObjects\Uuid;
use App\Shared\Domain\Utils;
use DateTimeImmutable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

abstract class DomainEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    protected readonly string $eventId;
    protected readonly string $occurredOn;

    public function __construct(protected readonly string $aggregateId, protected readonly array $body, string $eventId = null, string $occurredOn = null)
    {
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    public function toPrimitives(): array
    {
        return [
            'aggregate_id' => $this->aggregateId,
            'event_id' => $this->eventId,
            'occurred_on' => $this->occurredOn,
            'body' => $this->body,
        ];
    }

    final public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    final public function eventId(): string
    {
        return $this->eventId;
    }

    final public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    abstract public function dispatchSelf(): void;
}
