<?php

namespace App\User\Application\Commands\BlockUser;

use App\Shared\Application\Commands\Command;

final class BlockUserCommand extends Command
{
    private function __construct(
        private readonly string $uuid
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public static function create(string $uuid): BlockUserCommand
    {
        return new self($uuid);
    }
}
