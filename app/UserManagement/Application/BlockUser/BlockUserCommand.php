<?php

namespace App\UserManagement\Application\BlockUser;

use App\Shared\Domain\Bus\Command\Command;

class BlockUserCommand extends Command
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
