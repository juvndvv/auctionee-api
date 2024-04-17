<?php

namespace App\Auction\Infraestructure\Controllers;

use App\Auction\Domain\Ports\Inbound\DeleteAuctionByIdUseCasePort;
use App\Shared\Infraestructure\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DeleteByIdAuctionController extends Controller
{
    public function __construct(
        private readonly DeleteAuctionByIdUseCasePort $deleteAuctionByIdUseCase
    )
    {}

    public function __invoke($id): JsonResponse
    {
        // TODO: manejar ModelNotFound
        $this->deleteAuctionByIdUseCase->invoke($id);
        return response()->json(["message"=> "Deleted succesfully!"]);
    }
}
