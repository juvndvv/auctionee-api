<?php

namespace App\UserManagement\Application\FindByUsername;

class FindByUsernameQuery
{
    public function __construct(private readonly string $username)
    {}

    public function username(): string
    {
        return $this->username;
    }
}
