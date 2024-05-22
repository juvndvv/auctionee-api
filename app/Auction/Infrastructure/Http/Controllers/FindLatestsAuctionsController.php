<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Projections\AuctionAndUserProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Support\Facades\DB;

class FindLatestsAuctionsController
{
    public function __invoke()
    {
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
            ->whereRaw('DATE_ADD(NOW(), INTERVAL 2 HOUR) < DATE_ADD(auctions.starting_date, INTERVAL auctions.duration MINUTE)')
            ->orderBy('auctions.created_at', 'desc')
            ->limit(5)
            ->get();

        $resources = $auctionModels->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionAndUserProjection::fromPrimitives($auctionModel->toArray())
        );

        return Response::OK($resources, 'Ultimas encontradas');
    }
}
