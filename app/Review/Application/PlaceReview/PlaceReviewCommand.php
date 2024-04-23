<?php

namespace App\Review\Application\PlaceReview;


use App\Shared\Domain\Bus\Query\Query;

class PlaceReviewCommand extends Query
{
    public function __construct(
        private readonly string $reviewerUuid,
        private readonly string $reviewedUuid,
        private readonly string $description,
        private readonly int    $rating,
    )
    {}

    public function reviewerUuid(): string
    {
        return $this->reviewerUuid;
    }

    public function reviewedUuid(): string
    {
        return $this->reviewedUuid;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function rating(): int
    {
        return $this->rating;
    }
}
