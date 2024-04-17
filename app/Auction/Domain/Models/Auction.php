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
    public readonly AuctionGallery $gallery;
    public readonly BidList $bids;

    public function __construct(int $id, string $name, string $description, float $price, DateTime $initialDate, int $duration, array $imageUrlList)
    {
        $this->id = new AuctionId($id);
        $this->name = new AuctionName($name);
        $this->description = new AuctionDescription($description);
        $this->price = new AuctionPrice($price);
        $this->initialDate = new AuctionInitialDate($initialDate);
        $this->duration = new AuctionDuration($duration);
        $this->gallery = new AuctionGallery($imageUrlList);
    }

    public static function create(int $id, string $name, string $description, float $price, DateTime $initialDate, int $duration, array $gallery): Auction
    {
        return new Auction($id, $name, $description, $price, $initialDate, $duration, $gallery);
    }
}
