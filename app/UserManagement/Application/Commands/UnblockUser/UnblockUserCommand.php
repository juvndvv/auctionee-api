<?php

namespace App\UserManagement\Application\Commands\UnblockUser;

use App\Shared\Application\Commands\Command;

class UnblockUserCommand extends Command
{
    private function __construct(
        private readonly string $uuid
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
