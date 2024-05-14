<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Domain\Models\User;
use App\User\Domain\Projections\UserDetailsProjection;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;

class FindUserLikeController
{
    public function __invoke(string $str)
    {
        $userModels = EloquentUserModel::query()
            ->where('name', 'like', "%$str%")
            ->orWhere('username', 'like', "%$str%")
            ->get();

        $userDomains = $userModels->map(fn (EloquentUserModel $userModel) => User::fromPrimitives($userModel->toArray()));

        $resources = $userDomains->map(fn (User $user) => UserDetailsProjection::create($user));

        return Response::OK($resources, 'Usuarios encontrados');
    }
}
