<?php

namespace App\User\Application\Commands\DeleteUser;

use App\Shared\Application\Commands\Command;

final class DeleteUserCommand extends Command
{
    private function __construct(
        private readonly string $uuid
    )
    {}

    public static function create(string $uuid): DeleteUserCommand
    {
        return new self($uuid);
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}
