<?php

namespace App\User\Application\Commands\UpdatePassword;

use App\Shared\Application\Commands\Command;

final class UpdatePasswordCommand extends Command
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

    public static function create(string $uuid, string $password): UpdatePasswordCommand
    {
        return new self($uuid, $password);
    }
}
