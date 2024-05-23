<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Infrastructure\Repositories\Models\EloquentFavoriteModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteFavoriteController
{
    public function __invoke(Request $request, string $auctionUuid): JsonResponse
    {
        $userUuid = $request->user()->uuid;

        EloquentFavoriteModel::query()
            ->where('auction_uuid', $auctionUuid)
            ->where('user_id', $userUuid)
            ->delete();

        return Response::OK('', 'Eliminado correctamente');
    }
}
