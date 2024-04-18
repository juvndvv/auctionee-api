<?php

namespace App\UserManagement\Domain\Ports\Outbound;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryPort
{
    public function create(): Model;
    public function updateName(string $name): Model;
    public function updateUsername(string $username): Model;
    public function updateEmail(string $email): Model;
    public function updatePassword(string $password): Model;
}
