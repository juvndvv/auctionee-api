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

    public function findByUuid(string $uuid): ?Model
    {
        return EloquentUserModel::query()->where('uuid', $uuid)->first();
    }

    public function findByUsername(string $username): ?Model
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

    public function updateName(string $uuid, string $name): int
    {
        return EloquentUserModel::query()->findOrFail($uuid)->update(['name' => $name]);
    }

    public function updateUsername(string $uuid, string $username): int
    {
        return EloquentUserModel::query()->findOrFail($uuid)->update(['username' => $username]);
    }

    public function updateEmail(string $uuid, string $email): int
    {
        return EloquentUserModel::query()->findOrFail($uuid)->update(['email' => $email]);
    }

    public function updatePassword(string $uuid, string $password): int
    {
        return EloquentUserModel::query()->findOrFail($uuid)->update(['uuid' => $password]);
    }

    public function updateAvatar(string $uuid, string $avatar): int
    {
        return EloquentUserModel::query()->where('uuid', $uuid)->update(['avatar' => $avatar]);
    }

    public function delete(string $uuid): int
    {
        return EloquentUserModel::query()->where("uuid", $uuid)->delete();
    }

    public function block(string $uuid): int
    {
        return EloquentUserModel::query()->where("uuid", $uuid)->update(['role' => 2]);
    }

    public function unblock(string $uuid): int
    {
        return EloquentUserModel::query()->where("uuid", $uuid)->update(['role' => 0]);
    }
}
