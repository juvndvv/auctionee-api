<?php

namespace App\Auction\Domain\Models\Bid;

class BidEntity
{
    private BidAmount $amount;

    public function __construct(float $amount)
    {
        $this->amount = new BidAmount($amount);
    }

    public function amount(): float
    {
        return $this->amount->value();
    }
}
