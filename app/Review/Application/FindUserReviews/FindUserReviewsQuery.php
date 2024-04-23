<?php

namespace App\Review\Application\FindUserReviews;

class FindUserReviewsQuery
{
    public function __construct(private readonly string $reviewedUuid)
    {}

    public function reviewedUuid(): string
    {
        return $this->reviewedUuid;
    }
}
