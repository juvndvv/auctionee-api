<?php

namespace App\Auction\Domain\Ports\Outbound;

use App\Auction\Domain\Models\Bid\Bid;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;

interface BidRepositoryPort extends BaseRepositoryPort
{
    /**
     * @throws NoContentException
     */
    public function getTopBidOrFail(string $auctionUuid): Bid;
}
