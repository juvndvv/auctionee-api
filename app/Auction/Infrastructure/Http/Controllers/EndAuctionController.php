<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Infrastructure\Http\Controllers\Response;

class EndAuctionController
{
    public function __invoke(string $uuid)
    {
        EloquentAuctionModel::query()
            ->where('uuid', $uuid)
            ->update(['finished' => '1']);

        return Response::OK('', 'Subasta finalizada correctamente');
    }
}
