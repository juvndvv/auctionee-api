<?php

namespace App\User\Application\Queries\FindByUsername;


use App\Shared\Application\Queries\Query;

final class FindByUsernameQuery extends Query
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
