<?php

namespace App\Auction\Domain\Models;

use App\Auction\Domain\Models\ValueObjects\AuctionDescription;
use App\Auction\Domain\Models\ValueObjects\AuctionDuration;
use App\Auction\Domain\Models\ValueObjects\AuctionId;
use App\Auction\Domain\Models\ValueObjects\AuctionInitialDate;
use App\Auction\Domain\Models\ValueObjects\AuctionName;
use App\Auction\Domain\Models\ValueObjects\AuctionPrice;
use DateTime;

class Auction
{
    public readonly AuctionId $id;
    public readonly AuctionName $name;
    public readonly AuctionDescription $description;
    public readonly AuctionPrice $price;
    public readonly AuctionInitialDate $initialDate;
    public readonly AuctionDuration $duration;

    public function __construct(int $id, string $name, string $description, float $price, DateTime $initialDate, int $duration)
    {
        $this->id = new AuctionId($id);
        $this->name = new AuctionName($name);
        $this->description = new AuctionDescription($description);
        $this->price = new AuctionPrice($price);
        $this->initialDate = new AuctionInitialDate($initialDate);
        $this->duration = new AuctionDuration($duration);
    }

    public static function create(string $name, string $description, float $price, DateTime $initialDate)
    {
        return new Auction($name, $description, $price, $initialDate);
    }
}
