<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Models\Category\Category;
use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;
use App\Shared\Infrastructure\Http\Controllers\Response;

class FindCategoryByUuidController
{
    public function __invoke(string $uuid)
    {
        $category = EloquentCategoryModel::query()
            ->where('uuid', $uuid)
            ->first();
        return Response::OK($category, 'Categoria encontrada');
    }
}
