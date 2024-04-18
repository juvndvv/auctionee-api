<?php

namespace App\UserManagement\Infraestructure\Repositories;

use App\UserManagement\Domain\Ports\Outbound\AuthRepositoryPort;
use App\UserManagement\Infraestructure\Repositories\Models\EloquentUserModel;
use Illuminate\Database\Eloquent\Model;

class EloquentAuthRepository implements AuthRepositoryPort
{
    public function authenticate(string $email, string $password)
    {
        EloquentUserModel::query()
            ->where('email', $email)
            ->where('password', $password)
            ->firstOrFail();
    }

    public function register(array $data): Model
    {
        return EloquentUserModel::query()->create($data);
    }
}
