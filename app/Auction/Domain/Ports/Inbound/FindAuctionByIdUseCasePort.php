<?php

namespace App\Auction\Domain\Ports\Inbound;

use Illuminate\Database\Eloquent\Model;

interface FindAuctionByIdUseCasePort
{
    public function invoke($id): Model;
}
