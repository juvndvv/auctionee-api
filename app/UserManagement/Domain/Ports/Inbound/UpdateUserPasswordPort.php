<?php

namespace App\UserManagement\Domain\Ports\Inbound;

interface UpdateUserPasswordPort
{
    public function __invoke(string $password): string;
}
