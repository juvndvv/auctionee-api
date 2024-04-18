<?php

namespace App\UserManagement\Application\Create;

use App\Shared\Domain\Bus\Command\Command;

class CreateUserCommand extends Command
{
    public function __construct(
        private readonly string $name,
        private readonly string $username,
        private readonly string $email,
        private readonly string $password
    )
    {}

    public function name(): string
    {
        return $this->name;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
