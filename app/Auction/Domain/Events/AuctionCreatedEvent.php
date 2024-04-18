<?php

namespace App\Auction\Domain\Events;

use App\Shared\Domain\Bus\Events\DomainEvent;

class AuctionCreatedEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $name,
        private readonly string $description,
        private readonly float $price,
        private readonly int $duration,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self(
            $aggregateId,
            $body['name'],
            $body['description'],
            $body['price'],
            $body['duration'],
        );
    }

    public static function eventName(): string
    {
        return 'auction.created';
    }

    public function toPrimitives(): array
    {
        return [
            'aggregateId' => $this->aggregateId(),
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
        ];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function duration(): int
    {
        return $this->duration;
    }
}
