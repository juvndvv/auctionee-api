<?php

namespace App\UserManagement\Application\UpdateEmail;

use App\Shared\Infraestructure\Bus\Command\Command;

class UpdateEmailCommand extends Command
{
    public function __construct(private readonly string $uuid, private readonly string $email)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function email(): string
    {
        return $this->email;
    }
}
