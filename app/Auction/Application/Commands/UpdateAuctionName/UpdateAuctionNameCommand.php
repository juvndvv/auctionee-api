<?php

namespace App\Auction\Application\Commands\UpdateAuctionName;

use App\Shared\Application\Commands\Command;

final class UpdateAuctionNameCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $name,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public static function create(string $uuid, string $name): self
    {
        return new self($uuid, $name);
    }
}
