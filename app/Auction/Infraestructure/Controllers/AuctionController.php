<?php

namespace App\Auction\Infraestructure\Controllers;

use App\Auction\Domain\Ports\Inbound\AuctionServicePort;
use App\Shared\Infraestructure\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function __construct(
        private readonly AuctionServicePort $auctionService
    )
    {}

    public function findAll(): JsonResponse
    {
        $auctions = $this->auctionService->findAll();
        return response()->json($auctions);
    }

    public function create(Request $request): JsonResponse
    {
        $auctions = $this->auctionService->create($request->toArray());
        return response()->json($auctions);
    }

    public function findById($id): JsonResponse
    {
        $auction = $this->auctionService->findById($id);
        return response()->json($auction);
    }

    public function deleteById($id): JsonResponse
    {
        // TODO: manejar ModelNotFound
        $this->auctionService->deleteById($id);
        return response()->json(["message"=> "Deleted succesfully!"]);
    }
}
