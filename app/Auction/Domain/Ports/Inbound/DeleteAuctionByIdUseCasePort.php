<?php

namespace App\Auction\Domain\Ports\Inbound;

use Illuminate\Database\Eloquent\Model;

interface DeleteAuctionByIdUseCasePort
{
    public function invoke($id): bool;
}
