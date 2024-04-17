<?php

namespace App\Auction\Domain\Ports\Inbound;

use Illuminate\Database\Eloquent\Model;

interface CreateAuctionUseCasePort
{
    public function invoke(array $auctionData): Model;
}
