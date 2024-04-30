<?php

namespace App\Auction\Application\Command\UpdateName;

use App\Shared\Application\Commands\Command;

final class UpdateNameCommand extends Command
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
