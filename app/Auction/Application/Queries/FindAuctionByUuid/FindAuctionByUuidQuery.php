<?php

namespace App\Auction\Application\Queries\FindAuctionByUuid;

use App\Shared\Application\Queries\Query;

final class FindAuctionByUuidQuery extends Query
{
    public function __construct(
        private readonly string $uuid
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public static function create(string $uuid): FindAuctionByUuidQuery
    {
        return new self($uuid);
    }
}
