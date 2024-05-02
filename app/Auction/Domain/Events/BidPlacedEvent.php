<?php

namespace App\Auction\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;

final class BidPlacedEvent extends DomainEvent
{
    public function __construct(public string $auctionUuid, string $occurredOn, array $payload, string $eventId = null)
    {
        parent::__construct($occurredOn, $payload, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return ['auctions', 'auction.' . $this->auctionUuid];
    }

    public function broadcastAs(): string
    {
        return self::eventName();
    }

    public static function eventName(): string
    {
        return 'bid.placed';
    }
}
