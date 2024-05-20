<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Projections\CategoryProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Http\JsonResponse;

final class FindCategoriesLikeController
{
    public function __invoke(string $query): JsonResponse
    {
        $categoriesDb = EloquentCategoryModel::query()
            ->where('name', 'like', "%$query%")
            ->get();

        $resources = $categoriesDb->map(
            fn (EloquentCategoryModel $category) => CategoryProjection::create(
                $category->uuid,
                $category->name,
                $category->description,
                $category->avatar
            )
        );

        return Response::OK($resources, 'Categorias encontradas');
    }
}
