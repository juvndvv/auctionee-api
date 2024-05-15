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
        $categoryUuid = EloquentCategoryModel::query()
            ->select('uuid')
            ->where('name', $uuid)
            ->first()->name;

        $auctionModels = EloquentAuctionModel::query()
            ->where('category_uuid', $uuid)
            ->orWhere('category_uuid', $categoryUuid)
            ->get();

        $resources = $auctionModels->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionAndUserProjection::fromPrimitives($auctionModel->toArray())
        );

        return Response::OK($resources, 'Subastas de la categoria encontradas');
    }
}
