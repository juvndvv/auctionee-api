<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;
use App\Shared\Infrastructure\Http\Controllers\Response;

class FindTotalCategories
{
    public function __invoke()
    {
        return Response::OK(EloquentCategoryModel::all()->count(), 'Total Categories');
    }
}
