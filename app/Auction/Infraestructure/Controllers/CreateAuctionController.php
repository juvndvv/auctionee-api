<?php

namespace App\Auction\Infraestructure\Controllers;

use App\Auction\Domain\Ports\Inbound\CreateAuctionUseCasePort;
use App\Shared\Infraestructure\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAuctionController extends Controller
{
    public function __construct(
        private readonly CreateAuctionUseCasePort $createAuctionUseCase
    )
    {}

    public function __invoke(Request $request): JsonResponse
    {
        $auctions = $this->createAuctionUseCase->invoke($request->toArray());
        return response()->json($auctions);
    }
}
