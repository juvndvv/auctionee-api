<?php

namespace App\Auction\Application;

use App\Auction\Domain\Ports\Inbound\DeleteAuctionByIdUseCasePort;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;

class DeleteAuctionByIdUseCase implements DeleteAuctionByIdUseCasePort
{
    public function __construct(
        private readonly AuctionRepositoryPort $auctionRepository
    )
    {}

    public function invoke($id): bool
    {
        return $this->auctionRepository->deleteById($id);
    }
}
