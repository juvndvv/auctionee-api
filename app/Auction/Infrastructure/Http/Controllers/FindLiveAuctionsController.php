<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

final class FindLiveAuctionsController
{
    public function __invoke(): JsonResponse
    {
        return Response::OK(DB::select('
            SELECT
                auctions.uuid as uuid,
                auctions.name as name,
                auctions.description as description,
                auctions.starting_price as price,
                auctions.starting_date as date,
                auctions.duration as duration,
                auctions.avatar as avatar,
                users.uuid as user_uuid,
                users.username as user_username,
                users.avatar as user_avatar,
                categories.uuid as category_uuid,
                categories.name as category_name,
                categories.avatar as category_avatar
            FROM auctions
                JOIN users ON users.uuid = auctions.user_uuid
                JOIN categories ON categories.uuid = auctions.category_uuid
            WHERE
                NOW() BETWEEN auctions.starting_date AND DATE_ADD(auctions.starting_date, INTERVAL auctions.duration MINUTE)
        '), 'Subastas en directo encontradas');
    }
}
