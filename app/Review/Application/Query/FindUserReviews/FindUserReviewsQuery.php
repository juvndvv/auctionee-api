<?php

namespace App\Review\Application\Query\FindUserReviews;

use App\Shared\Application\Queries\Query;

final class FindUserReviewsQuery extends Query
{
    private function __construct(
        private readonly string $reviewedUuid
    )
    {}

    public function reviewedUuid(): string
    {
        return $this->reviewedUuid;
    }

    public static function create(string $reviewedUuid): self
    {
        return new self($reviewedUuid);
    }
}
