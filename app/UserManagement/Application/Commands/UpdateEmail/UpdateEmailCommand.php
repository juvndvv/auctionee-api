<?php

namespace App\UserManagement\Application\Commands\UpdateEmail;

use App\Shared\Application\Command;

class UpdateEmailCommand extends Command
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
}
