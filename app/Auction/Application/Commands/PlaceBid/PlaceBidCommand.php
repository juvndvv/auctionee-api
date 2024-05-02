<?php

namespace App\Auction\Application\Commands\PlaceBid;

use App\Shared\Application\Commands\Command;

final class PlaceBidCommand extends Command
{
    public function __construct(
        private readonly string $userUuid,
        private readonly float  $amount,
        private readonly string $auctionUuid
    )
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function auctionUuid(): string
    {
        return $this->auctionUuid;
    }

    public static function create(string $userUuid, float $amount, string $auctionUuid): self
    {
        return new self($userUuid, $amount, $auctionUuid);
    }
}
