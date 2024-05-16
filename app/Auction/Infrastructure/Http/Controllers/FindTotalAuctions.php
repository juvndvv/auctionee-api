<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Http\JsonResponse;

class FindTotalAuctions
{
    public function __invoke(): JsonResponse
    {
        return Response::OK(EloquentAuctionModel::all()->count(), 'Total encontrado');
    }
}
