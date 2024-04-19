<?php

namespace App\UserManagement\Application\UpdateEmail;

class UpdateEmailCommand
{
    public function __construct(private readonly string $uuid, private readonly string $email)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function email(): string
    {
        return $this->email;
    }
}
