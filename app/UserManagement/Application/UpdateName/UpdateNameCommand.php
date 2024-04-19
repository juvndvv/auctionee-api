<?php

namespace App\UserManagement\Application\UpdateName;

class UpdateNameCommand
{
    public function __construct(private readonly string $uuid, private readonly string $name)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }
}
