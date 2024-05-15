<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Projections\AuctionAndUserProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Infrastructure\Http\Controllers\Response;

class FindAuctionByCategoryUuid
{
    public function __invoke(string $uuid)
    {
        $auctionModels = EloquentAuctionModel::query()
            ->where('category_uuid', $uuid)
            ->get();

        $resources = $auctionModels->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionAndUserProjection::fromPrimitives($auctionModel->toArray())
        );

        return Response::OK($resources, 'Subastas de la categoria encontradas');
    }
}
