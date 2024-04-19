<?php

namespace App\UserManagement\Application\UnblockUser;

class UnblockUserCommand
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
