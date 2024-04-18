<?php

namespace App\UserManagement\Application\FindById;

class FindByIdQuery
{
    public function __construct(private readonly string $id)
    {}

    public function id(): string
    {
        return $this->id;
    }
}
