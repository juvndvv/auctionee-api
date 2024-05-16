<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Infrastructure\Http\Controllers\Response;

class DeleteAuctionController
{
    public function __invoke(string $uuid)
    {
        EloquentAuctionModel::query()->where('uuid', $uuid)->delete();
        return Response::OK('', 'Subasta eliminada');
    }
}
