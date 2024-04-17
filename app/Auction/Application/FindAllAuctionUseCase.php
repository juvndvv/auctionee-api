<?php

namespace App\Auction\Application;

use App\Auction\Domain\Ports\Inbound\FindAllAuctionUseCasePort;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use Illuminate\Database\Eloquent\Collection;

class FindAllAuctionUseCase implements FindAllAuctionUseCasePort
{
    public function __construct(
        private readonly AuctionRepositoryPort $auctionRepository
    )
    {}

    public function invoke(): Collection
    {
        return $this->auctionRepository->findAll();
    }
}
