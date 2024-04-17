<?php

namespace App\Auction\Application;

use App\Auction\Domain\Ports\Inbound\FindAuctionByIdUseCasePort;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use Illuminate\Database\Eloquent\Model;

class FindAuctionByIdUseCase implements FindAuctionByIdUseCasePort
{
    public function __construct(
        private readonly AuctionRepositoryPort $auctionRepository
    )
    {}

    public function invoke($id): Model
    {
        return $this->auctionRepository->find($id);
    }
}
