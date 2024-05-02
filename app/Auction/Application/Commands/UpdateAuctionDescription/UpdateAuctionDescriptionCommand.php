<?php

namespace App\Auction\Application\Commands\UpdateAuctionDescription;

final class UpdateAuctionDescriptionCommand
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $description,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function description(): string
    {
        return $this->description;
    }

    public static function create(string $uuid, string $name): self
    {
        return new self($uuid, $name);
    }
}
