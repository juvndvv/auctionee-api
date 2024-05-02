<?php

namespace App\Auction\Application\Queries\FindAllAuctionByUserUuid;

use App\Shared\Application\Queries\Query;

final class FindAllAuctionsByUserUuidQuery extends Query
{
    public function __construct(
        private readonly string $userUuid,
        private readonly int $offset,
        private readonly int $limit
    )
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public static function create(string $userUuid, int $offset, int $limit): self
    {
        return new self($userUuid, $offset, $limit);
    }
}
