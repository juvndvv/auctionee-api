<?php

namespace App\UserManagement\Application;

use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Inbound\CreateUserPort;

class UserCreator implements CreateUserPort
{
    public function __invoke(array $data): string
    {
        // TODO: validar

        $user = User::create(
            $data['name'],
            $data['username'],
            $data['email'],
            $data['password']
        );

        return $user->username();
    }
}
