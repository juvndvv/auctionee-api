<?php

namespace App\User\Application\Commands\UpdateEmail;

use App\Shared\Application\Commands\Command;

final class UpdateEmailCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $email
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function email(): string
    {
        return $this->email;
    }

    public static function create(string $uuid, string $email): UpdateEmailCommand
    {
        return new self($uuid, $email);
    }
}
