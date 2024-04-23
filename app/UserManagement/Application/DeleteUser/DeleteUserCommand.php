<?php

namespace App\UserManagement\Application\DeleteUser;

use App\Shared\Domain\Bus\Command\Command;

class DeleteUserCommand extends Command
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}