<?php

namespace App\Auction\Domain\Models\Bid;

use App\Auction\Domain\Events\BidPlacedEvent;
use App\Auction\Domain\Models\Auction\ValueObjects\AuctionUuid;
use App\Auction\Domain\Models\Bid\ValueObjects\BidAmount;
use App\Auction\Domain\Models\Bid\ValueObjects\BidUuid;
use App\Shared\Domain\Models\AggregateRoot;
use App\User\Domain\Models\ValueObjects\UserUuid;

final class Bid extends AggregateRoot
{
    public const string UUID = 'uuid';
    public const string AMOUNT = 'amount';
    public const string USER_UUID = 'user_uuid';
    public const string AUCTION_UUID = 'auction_uuid';

    private BidUuid $uuid;
    private BidAmount $amount;
    private UserUuid $userUuid;
    private AuctionUuid $auctionUuid;

    public function __construct(string $uuid, float $amount, string $userUuid, string $auctionUuid)
    {
        $this->uuid = new BidUuid($uuid);
        $this->amount = new BidAmount($amount);
        $this->userUuid = new UserUuid($userUuid);
        $this->auctionUuid = new AuctionUuid($auctionUuid);
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function amount(): float
    {
        return $this->amount->value();
    }

    public function userUuid(): string
    {
        return $this->userUuid->value();
    }

    public function auctionUuid(): string
    {
        return $this->auctionUuid->value();
    }

    public function toPrimitives(): array
    {
        return [
            self::UUID => $this->uuid(),
            self::AMOUNT => $this->amount(),
            self::USER_UUID => $this->userUuid(),
            self::AUCTION_UUID => $this->auctionUuid(),
        ];
    }

    public static function create(float $amount, string $userUuid, string $auctionUuid): self
    {
        $uuid = BidUuid::random()->value();
        $bid = new self($uuid, $amount, $userUuid, $auctionUuid);
        $bid->record(new BidPlacedEvent($auctionUuid, now()->toString(), $bid->toPrimitives()));
        return $bid;
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data[self::UUID],
            $data[self::AMOUNT],
            $data[self::USER_UUID],
            $data[self::AUCTION_UUID]
        );
    }
}
