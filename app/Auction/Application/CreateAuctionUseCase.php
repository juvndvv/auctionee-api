<?php

namespace App\Auction\Application;

use App\Auction\Domain\Ports\Inbound\CreateAuctionUseCasePort;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use Illuminate\Database\Eloquent\Model;

class CreateAuctionUseCase implements CreateAuctionUseCasePort
{
    public function __construct(
        private readonly AuctionRepositoryPort $auctionRepository
    )
    {}

    public function invoke(array $auctionData): Model
    {
        return $this->auctionRepository->create($auctionData);
    }
}
