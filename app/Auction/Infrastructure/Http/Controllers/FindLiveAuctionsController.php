<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Projections\AuctionAndUserProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class FindLiveAuctionsController
{
    public function __invoke()
    {
        $auctionModels = DB::table('auctions')
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
            ])
            ->join('users', 'users.uuid', '=', 'auctions.user_uuid')
            ->join('categories', 'categories.uuid', '=', 'auctions.category_uuid')
            ->where('auctions.starting_date', '<=', Carbon::now())
            ->where(DB::raw('DATE_ADD(auctions.starting_date, INTERVAL auctions.duration SECOND)'), '>=', Carbon::now())
            ->get();

        $resources = $auctionModels->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionAndUserProjection::fromPrimitives($auctionModel->toArray())
        );

        return Response::OK($resources, 'Subastas en directo encontradas');
    }
}
