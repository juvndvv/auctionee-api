<?php

namespace App\UserManagement\Application\Commands\BlockUser;

use App\Shared\Application\Command;

class BlockUserCommand extends Command
{
    private function __construct(
        private readonly string $uuid
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
