<?php

namespace App\UserManagement\Application\FindByUsername;

use App\Shared\Infraestructure\Bus\Query\Query;

class FindByUsernameQuery extends Query
{
    public function __construct(private readonly string $username)
    {}

    public function username(): string
    {
        return $this->username;
    }
}
