<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;

final class FindCategoryByAuctionController
{
    public function __invoke(string $uuid)
    {
        $category = EloquentCategoryModel::query()
            ->select([
                'categories.uuid as uuid',
                'categories.name as name',
                'categories.description as description',
                'categories.avatar as avatar',
            ])->join('auctions', 'auctions.category_uuid', '=', 'categories.uuid')
            ->where('auctions.uuid', $uuid)
            ->first();

        return $category->toArray();
    }
}
