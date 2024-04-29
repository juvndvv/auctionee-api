<?php

namespace App\Review\Domain\Resources;

class ReviewDetailsResource
{
    public function __construct(
        public string $reviewerUsername,
        public string $reviewerAvatar,
        public int $rating,
        public string $description,
        public string $createdAt
    )
    {}

    public static function create(
        string $reviewerUsername,
        string $reviewerAvatar,
        int $rating,
        string $description,
        string $createdAt
    ): self
    {
        return new self(
            $reviewerUsername,
            $reviewerAvatar,
            $rating,
            $description,
            $createdAt
        );
    }
}
