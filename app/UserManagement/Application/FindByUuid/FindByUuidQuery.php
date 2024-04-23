<?php

namespace App\UserManagement\Application\FindByUuid;

use App\Shared\Domain\Bus\Query\Query;

class FindByUuidQuery extends Query
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
