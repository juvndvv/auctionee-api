<?php

namespace App\Auction\Application\Queries\FindAllAuctions;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Domain\Resources\AuctionResource;
use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
use Illuminate\Support\Collection;

final class FindAllAuctionsQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly AuctionRepositoryPort $auctionRepository
    )
    {}

    /**
     * @param FindAllAuctionsQuery $query
     * @return Collection<AuctionResource>
     * @throws NoContentException
     */
    public function __invoke(FindAllAuctionsQuery $query): Collection
    {
        $offset = $query->offset();
        $limit = $query->limit();

        return $this->auctionRepository->findAll($offset, $limit);
    }
}
