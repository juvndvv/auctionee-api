<?php

namespace App\User\Application\Commands\Authenticate;

use App\Shared\Application\Commands\Command;

final class AuthenticateCommand extends Command
{
    private function __construct(
        private readonly string $email,
        private readonly string $password
    )
    {}

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public static function create(string $email, string $password): self
    {
        return new self($email, $password);
    }
}
