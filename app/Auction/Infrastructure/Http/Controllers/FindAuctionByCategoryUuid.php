<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Projections\AuctionAndUserProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use function Laravel\Prompts\select;

class FindAuctionByCategoryUuid
{
    public function __invoke(string $uuid)
    {
        $categoryModel = EloquentCategoryModel::query()
            ->select('uuid')
            ->where('name', $uuid)
            ->first();

        if (!is_null($categoryModel)) {
            $categoryUuid = $categoryModel->uuid;
        } else {
            $categoryUuid = $uuid;
        }

        $auctionModels = EloquentAuctionModel::query()
            ->select([
                'auctions.uuid as uuid',
                'auctions.name as name',
                'auctions.description as description',
                'auctions.starting_price as price',
                'auctions.starting_date as date',
                'auctions.duration as duration',
                'auctions.avatar as avatar',
                'users.uuid as user_uuid',
                'users.username as user_username',
                'users.avatar as user_avatar',
                'categories.uuid as category_uuid',
                'categories.name as category_name',
                'categories.avatar as category_avatar',
            ])->join('users', 'users.uuid', '=', 'auctions.user_uuid')
            ->join('categories', 'categories.uuid', '=', 'auctions.category_uuid')
            ->where('category_uuid', $categoryUuid)
            ->get();

        $resources = $auctionModels->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionAndUserProjection::fromPrimitives($auctionModel->toArray())
        );

        return Response::OK($resources, 'Subastas de la categoria encontradas');
    }
}
