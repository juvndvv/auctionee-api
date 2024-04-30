<?php

namespace App\Auction\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;
use App\Shared\Domain\Models\ValueObjects\Uuid;

final class AuctionPlacedEvent extends DomainEvent
{
    public function __construct(string $occurredOn, array $payload, string $eventId = null)
    {
        parent::__construct($occurredOn, $payload, self::eventName(), $eventId);
    }

    public function broadcastOn(): array
    {
        return ['auctions'];
    }

    public function broadcastAs(): string
    {
        return self::eventName();
    }

    public static function eventName(): string
    {
        return 'auction.placed';
    }
}
