<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Http\JsonResponse;

final class DeleteCategoryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        if (EloquentAuctionModel::query()->where('category_uuid', $uuid)->exists()) {
            return Response::UNPROCESSABLE_ENTITY('La categoria tiene subastas', '');
        }

        EloquentCategoryModel::query()->where('uuid', $uuid)->delete();
        return Response::OK('', 'Categoria eliminada');
    }
}
