<?php

namespace App\Review\Application\Command\PlaceReview;

use App\Shared\Application\Queries\Query;

class PlaceReviewCommand extends Query
{
    private function __construct(
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

    public static function create(string $reviewerUuid, string $reviewedUuid, string $description, int $rating): PlaceReviewCommand
    {
        return new self($reviewerUuid, $reviewedUuid, $description, $rating);
    }
}
