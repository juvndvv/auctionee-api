<?php

namespace App\UserManagement\Application\Commands\UpdatePassword;

use App\Shared\Application\Command;

class UpdatePasswordCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $password
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function password(): string
    {
        return $this->password;
    }
}
