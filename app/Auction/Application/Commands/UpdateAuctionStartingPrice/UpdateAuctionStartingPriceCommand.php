<?php

namespace App\Auction\Application\Commands\UpdateAuctionStartingPrice;

use App\Shared\Application\Commands\Command;

final class UpdateAuctionStartingPriceCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $startingPrice,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function startingPrice(): string
    {
        return $this->startingPrice;
    }

    public static function create(string $uuid, float $startingPrice): self
    {
        return new self($uuid, $startingPrice);
    }
}
