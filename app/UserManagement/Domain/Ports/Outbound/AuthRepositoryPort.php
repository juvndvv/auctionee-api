<?php

namespace App\Authentication\Domain\Ports\Outbound;

interface AuthRepositoryPort
{
    public function authenticate(string $email, string $password);
    public function register(array $data);
}
