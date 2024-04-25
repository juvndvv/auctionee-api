<?php

namespace App\UserManagement\Application\Queries\FindByUsername;


use App\Shared\Application\Query;

class FindByUsernameQuery extends Query
{
    private function __construct(
        private readonly string $username
    )
    {}

    public function username(): string
    {
        return $this->username;
    }
}
