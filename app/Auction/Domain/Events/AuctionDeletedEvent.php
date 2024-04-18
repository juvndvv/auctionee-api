<?php

namespace App\Auction\Domain\Events;

use App\Shared\Domain\Bus\Events\DomainEvent;

class AuctionDeletedEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self(
            $aggregateId,
        );
    }

    public static function eventName(): string
    {
        return 'auction.deleted';
    }

    public function toPrimitives(): array
    {
        return [
            'aggregateId' => $this->aggregateId(),
        ];
    }
}
