<?php

namespace App\UserManagement\Application\Queries\FindByUuid;

use App\Shared\Application\Query;

class FindByUuidQuery extends Query
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
