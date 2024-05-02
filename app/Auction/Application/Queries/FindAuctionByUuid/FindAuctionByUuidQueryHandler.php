<?php

namespace App\Auction\Application\Queries\FindAuctionByUuid;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Domain\Projections\AuctionDetailedProjection;
use App\Shared\Application\Commands\QueryHandler;

final class FindAuctionByUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly AuctionRepositoryPort $auctionRepository
    )
    {}

    public function __invoke(FindAuctionByUuidQuery $query): AuctionDetailedProjection
    {
        return $this->auctionRepository->findByUuid($query->uuid());
    }
}
