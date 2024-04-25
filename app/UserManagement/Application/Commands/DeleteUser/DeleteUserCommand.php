<?php

namespace App\UserManagement\Application\Commands\DeleteUser;

use App\Shared\Application\Commands\Command;

class DeleteUserCommand extends Command
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
