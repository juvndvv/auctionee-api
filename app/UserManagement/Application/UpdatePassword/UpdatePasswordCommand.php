<?php

namespace App\UserManagement\Application\UpdatePassword;

use App\Shared\Infraestructure\Bus\Command\Command;

class UpdatePasswordCommand extends Command
{
    public function __construct(private readonly string $uuid, private readonly string $password)
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
