<?php

namespace App\UserManagement\Application\UpdateUsername;

class UpdateUsernameCommand
{
    public function __construct(private readonly string $uuid, private readonly string $username)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function username(): string
    {
        return $this->username;
    }
}
