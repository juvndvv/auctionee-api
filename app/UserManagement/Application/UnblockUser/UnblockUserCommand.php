<?php

namespace App\UserManagement\Application\UnblockUser;

use App\Shared\Domain\Bus\Command\Command;

class UnblockUserCommand extends Command
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
