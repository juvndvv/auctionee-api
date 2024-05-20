<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Projections\AuctionAndUserProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Infrastructure\Http\Controllers\Response;

class FindAuctionsLikeController
{
    public function __invoke(string $query)
    {
        $auctionsDb = EloquentAuctionModel::query()
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
            ->where('auctions.name', 'like', "%$query%")
            ->get();

        $resources = $auctionsDb->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionAndUserProjection::fromPrimitives($auctionModel->toArray())
        );

        return Response::OK($resources, 'Suabastas encontradas');
    }
}
