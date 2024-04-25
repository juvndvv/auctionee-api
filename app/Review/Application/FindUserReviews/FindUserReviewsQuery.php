<?php

namespace App\Review\Application\FindUserReviews;

use App\Shared\Infraestructure\Bus\Query\Query;

class FindUserReviewsQuery extends Query
{
    public function __construct(private readonly string $reviewedUuid)
    {}

    public function reviewedUuid(): string
    {
        return $this->reviewedUuid;
    }
}
