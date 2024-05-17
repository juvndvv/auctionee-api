<?php

namespace App\Auction\Application\Queries\FindAllAuctionByUserUuid;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
use Illuminate\Support\Collection;

final class FindAllAuctionsByUserUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly AuctionRepositoryPort $auctionRepository
    )
    {}

    /**
     * @throws NoContentException
     */
    public function __invoke(FindAllAuctionsByUserUuidQuery $query): Collection
    {
        $userUuid = $query->userUuid();

        return $this->auctionRepository->findByUserUuid($userUuid);
    }
}
