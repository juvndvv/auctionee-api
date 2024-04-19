<?php

namespace App\UserManagement\Domain\Ports\Outbound;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryPort
{
    public function findAll(): Collection;
    public function findByUuid(string $uuid): ?Model;
    public function findByUsername(string $username): ?Model;
    public function create(array $data): Model;
    public function updateName(string $uuid, string $name): int;
    public function updateUsername(string $uuid, string $username): int;
    public function updateEmail(string $uuid, string $email): int;
    public function updatePassword(string $uuid, string $password): int;
    public function updateAvatar(string $uuid, string $avatar): int;
    public function delete(string $uuid): int;
    public function block(string $uuid): int;
    public function unblock(string $uuid): int;
}
