<?php

namespace App\Auction\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;

final class AuctionUpdatedEvent extends DomainEvent
{
    public function __construct(
        public string $userUuid,
        string $occurredOn,
        array $payload,
        string $eventId = null
    )
    {
        parent::__construct($occurredOn, $payload, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return ['user.' . $this->userUuid];
    }

    public function broadcastAs(): string
    {
        return self::eventName();
    }

    public static function eventName(): string
    {
        return 'auction.updated';
    }
}
