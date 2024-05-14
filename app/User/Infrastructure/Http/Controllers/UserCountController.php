<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Illuminate\Http\JsonResponse;

class UserCountController
{
    public function __invoke(): JsonResponse
    {
        return Response::OK(
            EloquentUserModel::all()->count(),
            'Peticion realizada con exito'
        );
    }
}
