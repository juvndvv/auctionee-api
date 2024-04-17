<?php

namespace App\Auction\Domain\Models;

use DateTime;

class Auction
{
    public readonly AuctionName $name;
    public readonly AuctionDescription $description;
    public readonly AuctionPrice $price;
    public readonly AuctionInitialDate $initialDate;

    public function __construct(string $name, string $description, float $price, DateTime $initialDate)
    {
        $this->name = new AuctionName($name);
        $this->description = new AuctionDescription($description);
        $this->price = new AuctionPrice($price);
        $this->initialDate = new AuctionInitialDate($initialDate);
    }
}
