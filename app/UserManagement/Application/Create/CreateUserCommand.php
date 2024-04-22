<?php

namespace App\UserManagement\Application\Create;

use App\Shared\Domain\Bus\Command\Command;

class CreateUserCommand extends Command
{
    public function __construct(
        private readonly string $name,
        private readonly string $username,
        private readonly string $email,
        private readonly string $password,
        private readonly string $avatar,
        private readonly string $birth,
        private readonly int $role
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

    public function avatar(): string
    {
        return $this->avatar;
    }

    public function birth(): string
    {
        return $this->birth;
    }

    public function role(): int
    {
        return $this->role;
    }
}
