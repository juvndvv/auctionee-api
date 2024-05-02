<?php

namespace App\Auction\Application\Queries\FindAllAuctions;

use App\Shared\Application\Queries\Query;

final class FindAllAuctionsQuery extends Query
{
    private function __construct(
        private readonly int $offset,
        private readonly int $limit
    )
    {}

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public static function create(int $offset, $limit): self
    {
        return new self($offset, $limit);
    }
}
