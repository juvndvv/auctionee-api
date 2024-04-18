<?php

namespace App\UserManagement\Domain\Ports\Outbound;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryPort
{
    public function findAll(): Collection;
    public function findByUsername(string $username): Model;
    public function create(array $data): Model;
    public function updateName(string $name): Model;
    public function updateUsername(string $username): Model;
    public function updateEmail(string $email): Model;
    public function updatePassword(string $password): Model;
}
