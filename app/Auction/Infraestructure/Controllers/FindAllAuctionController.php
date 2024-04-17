<?php

namespace App\Auction\Infraestructure\Controllers;

use App\Auction\Domain\Ports\Inbound\AuctionServicePort;
use App\Auction\Domain\Ports\Inbound\FindAllAuctionUseCasePort;
use App\Shared\Infraestructure\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FindAllAuctionController extends Controller
{
    public function __construct(
        private readonly FindAllAuctionUseCasePort $findAllAuctionUseCase
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $auctions = $this->findAllAuctionUseCase->invoke();
        return response()->json($auctions);
    }
}
