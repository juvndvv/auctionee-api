<?php

namespace App\Auction\Application\Commands\UpdateAuctionDuration;

use App\Shared\Application\Commands\Command;

final class UpdateAuctionDurationCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly int $duration,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function duration(): int
    {
        return $this->duration;
    }

    public static function create(string $uuid, int $duration): self
    {
        return new self($uuid, $duration);
    }
}
