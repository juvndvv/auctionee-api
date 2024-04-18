<?php

namespace App\UserManagement\Domain\Ports\Inbound;

interface CreateUserPort
{
    public function __invoke(array $data): string;
}
