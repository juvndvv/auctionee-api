<?php

namespace App\Http\Controllers;

use App\Services\AuctionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Auction;

readonly class AuctionController
{
    public function __construct(
        private AuctionService $auctionService
    ){}

    public function findAll(): JsonResponse
    {
        $auctions = $this->auctionService->findAll();
        return response()->json($auctions);
    }

    public function create(Request $request): JsonResponse
    {
        $auctions = Auction::create($request->all());

        return response()->json($auctions);
    }

    public function findById($id): JsonResponse
    {
        $auctions = Auction::find($id);
        return response()->json($auctions);
    }

    public function deleteById($id): JsonResponse
    {
        Auction::find($id)->delete();
        return response()->json(["message"=> "Deleted succesfully!"]);
    }
}
