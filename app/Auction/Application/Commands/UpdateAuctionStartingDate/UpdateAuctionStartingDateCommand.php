<?php

namespace App\Auction\Application\Commands\UpdateAuctionStartingDate;

use App\Shared\Application\Commands\Command;

final class UpdateAuctionStartingDateCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $startingDate,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function startingDate(): string
    {
        return $this->startingDate;
    }

    public static function create(string $uuid, string $startingDate): self
    {
        return new self($uuid, $startingDate);
    }
}
