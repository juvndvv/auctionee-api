<?php

namespace App\UserManagement\Infraestructure\Repositories;

use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use App\UserManagement\Infraestructure\Repositories\Models\EloquentUserModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserEloquentRepository implements UserRepositoryPort
{
    public function findAll(): Collection
    {
        return EloquentUserModel::all();
    }

    public function findByUsername(string $username): Model
    {
        return EloquentUserModel::query()->where('username', $username)->first();
    }

    public function create(array $data): Model
    {
        return EloquentUserModel::query()->create($data);
    }

    public function existsByEmail(string $email): bool
    {
        return EloquentUserModel::query()->where('email', $email)->exists();
    }

    public function existsByUsername(string $username): bool
    {
        return EloquentUserModel::query()->where('username', $username)->exists();
    }

    public function updateName(string $name): Model
    {
        // TODO: Implement updateName() method.
    }

    public function updateUsername(string $username): Model
    {
        // TODO: Implement updateUsername() method.
    }

    public function updateEmail(string $email): Model
    {
        // TODO: Implement updateEmail() method.
    }

    public function updatePassword(string $password): Model
    {
        // TODO: Implement updatePassword() method.
    }
}
