<?php

namespace App\Auction\Domain\Ports\Inbound;

use Illuminate\Database\Eloquent\Collection;

interface FindAllAuctionUseCasePort
{
    public function invoke(): Collection;
}
