<?php

namespace App\UserManagement\Domain\Ports\Inbound;

interface UpdateUserUsernamePort
{
    public function __invoke(string $username): string;
}
