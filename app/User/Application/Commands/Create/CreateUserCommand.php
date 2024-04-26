<?php

namespace App\User\Application\Commands\Create;

use App\Shared\Application\Commands\Command;

final class CreateUserCommand extends Command
{
    private function __construct(
        private readonly string $name,
        private readonly string $username,
        private readonly string $email,
        private readonly string $password,
        private readonly string $avatar,
        private readonly string $birth,
        private readonly int $role
    )
    {}

    public static function create(
        string $name,
        string $username,
        string $email,
        string $password,
        string $avatar,
        string $birth,
        int $role
    ): CreateUserCommand
    {
        return new self($name, $username, $email, $password, $avatar, $birth, $role);
    }

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
