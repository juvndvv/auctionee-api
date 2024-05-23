<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Infrastructure\Repositories\Models\EloquentFavoriteModel;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddFavoriteController
{
    public function __invoke(Request $request, string $auctionUuid): JsonResponse
    {
        $userUuid = $request->user()->uuid;

        EloquentFavoriteModel::query()
            ->create(['user_uuid' => $userUuid, 'auction_uuid' => $auctionUuid]);

        return Response::OK('', 'Añadido correctamente');
    }
}
