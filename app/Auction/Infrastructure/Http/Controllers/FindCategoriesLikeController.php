<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Projections\CategoryProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindCategoriesLikeController
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = $request['query'];

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
