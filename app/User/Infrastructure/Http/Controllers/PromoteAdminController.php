<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Illuminate\Http\JsonResponse;

class PromoteAdminController
{
    public function __invoke(string $uuid): JsonResponse
    {
        EloquentUserModel::query()->where(['uuid' => $uuid])->update(['role' => 1]);
        return Response::OK('', 'Promocionado a admin');
    }
}
