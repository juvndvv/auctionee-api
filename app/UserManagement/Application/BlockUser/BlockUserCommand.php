<?php

namespace App\UserManagement\Application\BlockUser;

class BlockUserCommand
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
