<?php

namespace App\UserManagement\Domain\Ports\Inbound;

interface UpdateUserEmailPort
{
    public function __invoke(string $email): string;
}
