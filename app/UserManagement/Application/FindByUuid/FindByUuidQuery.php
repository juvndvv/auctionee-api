<?php

namespace App\UserManagement\Application\FindByUuid;

class FindByUuidQuery
{
    public function __construct(private readonly string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
