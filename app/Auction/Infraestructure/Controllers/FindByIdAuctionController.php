<?php

namespace App\Auction\Infraestructure\Controllers;

use App\Auction\Domain\Ports\Inbound\AuctionServicePort;
use App\Auction\Domain\Ports\Inbound\FindAuctionByIdUseCasePort;
use App\Shared\Infraestructure\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FindByIdAuctionController extends Controller
{
    public function __construct(
        private readonly FindAuctionByIdUseCasePort $findAuctionByIdUseCase
    )
    {}

    public function __invoke($id): JsonResponse
    {
        $auction = $this->findAuctionByIdUseCase->invoke($id);
        return response()->json($auction);
    }
}
