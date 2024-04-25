<?php

namespace App\UserManagement\Application\UpdateUsername;

use App\Shared\Infraestructure\Bus\Command\Command;

class UpdateUsernameCommand extends Command
{
    public function __construct(private readonly string $uuid, private readonly string $username)
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
