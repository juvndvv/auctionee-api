<?php

namespace App\Auction\Application\Queries\FindAllAuctionByUserUuid;

use App\Shared\Application\Queries\Query;

final class FindAllAuctionsByUserUuidQuery extends Query
{
    public function __construct(
        private readonly string $userUuid,
    )
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public static function create(string $userUuid): self
    {
        return new self($userUuid);
    }
}
