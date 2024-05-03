<?php

namespace App\Review\Application\Query\FindUserReviews;

use App\Shared\Application\Queries\Query;

final class FindUserReviewsQuery extends Query
{
    private function __construct(
        private readonly string $reviewedUuid,
        private readonly int $offset,
        private readonly int $limit
    )
    {}

    public function reviewedUuid(): string
    {
        return $this->reviewedUuid;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public static function create(string $reviewedUuid, string $offset, string $limit): self
    {
        return new self($reviewedUuid, $offset, $limit);
    }
}
