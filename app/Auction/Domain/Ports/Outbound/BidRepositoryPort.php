<?php

namespace App\Auction\Domain\Ports\Outbound;

use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;

interface BidRepositoryPort extends BaseRepositoryPort
{
    public function getTopBid(string $auctionUuid);
}
