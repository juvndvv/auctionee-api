<?php

namespace App\UserManagement\Application\Commands\UpdateUsername;

use App\Shared\Application\Command;

class UpdateUsernameCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $username
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function username(): string
    {
        return $this->username;
    }
}
