<?php

namespace App\UserManagement\Domain\Ports\Inbound;

interface UpdateUserNamePort
{
    public function __invoke(string $name): string;
}
