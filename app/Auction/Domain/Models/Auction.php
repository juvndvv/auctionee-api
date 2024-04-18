<?php

namespace App\Auction\Domain\Models;

use App\Auction\Domain\Events\AuctionCreatedEvent;
use App\Auction\Domain\Events\AuctionDeletedEvent;
use App\Auction\Domain\Events\AuctionUpdatedEvent;
use App\Auction\Domain\Models\Bid\BidEntity;
use App\Auction\Domain\Models\Product\ProductEntity;
use App\Shared\Domain\Models\AggregateRoot;

class Auction extends AggregateRoot
{
    private AuctionId $id;
    private ProductEntity $product;
    private AuctionPrice $price;
    public AuctionDuration $duration;
    public array/*BidEntity*/ $bids;

    public function __construct(string $id, string $name, string $description, float $price, int $duration, array $bids = [])
    {
        $this->id = new AuctionId($id);
        $this->product = new ProductEntity($name, $description);
        $this->price = new AuctionPrice($price);
        $this->duration = new AuctionDuration($duration);

        foreach ($bids as $amount) {
            $this->bids[] = new BidEntity($amount);
        }
    }

    public static function create(string $name, string $description, float $price, int $duration): Auction
    {
        $generatedId = AuctionId::random();
        $auction = new self($generatedId, $name, $description, $price, $duration);
        $auction->record(new AuctionCreatedEvent($generatedId, $name, $description, $price, $duration));
        return $auction;
    }

    public function delete(): void
    {
        $this->record(new AuctionDeletedEvent($this->id));
    }

    public function updateProductName(string $new): void
    {
        $old = $this->product->name();
        $this->product->updateName($new);
        $this->record(new AuctionUpdatedEvent($this->id->value(), "name", $old, $new));
    }

    public function updateProductDescription(string $new): void
    {
        $old = $this->product->description();
        $this->product->updateDescription($new);
        $this->record(new AuctionUpdatedEvent($this->id->value(), "description", $old, $new));
    }

    public function updatePrice(float $new): void
    {
        $old = $this->price();
        $this->price = new AuctionPrice($new);
        $this->record(new AuctionUpdatedEvent($this->id->value(), "price", sprintf("%f", $old), sprintf("%f", $new)));
    }

    public function updateDuration(int $new): void
    {
        $old = $this->duration();
        $this->duration = new AuctionDuration($new);
        $this->record(new AuctionUpdatedEvent($this->id->value(), "duration", sprintf("%d", $old), sprintf("%d", $new)));
    }

    public function pushBid($amount /*TODO user id*/): void
    {
        // TODO check if amount is bigger and auction has ended
        array_push($this->bids, new BidEntity($amount));
    }

    public function id(): string
    {
        return $this->id->value();
    }

    public function product(): ProductEntity
    {
        return $this->product;
    }

    public function price(): float
    {
        return $this->price->value();
    }

    public function duration(): int
    {
        return $this->duration->value();
    }

    public function bids(): array
    {
        return $this->bids;
    }
}
