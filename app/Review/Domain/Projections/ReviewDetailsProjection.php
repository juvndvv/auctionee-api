<?php

namespace App\Review\Domain\Projections;

final class ReviewDetailsProjection
{
    public function __construct(
        public string   $uuid,
        public string   $reviewerUsername,
        public string   $reviewerAvatar,
        public int      $rating,
        public string   $description,
        public string   $createdAt
    )
    {}

    public static function create(
        string  $uuid,
        string  $reviewerUsername,
        string  $reviewerAvatar,
        int     $rating,
        string  $description,
        string  $createdAt
    ): self
    {
        return new self(
            $uuid,
            $reviewerUsername,
            $reviewerAvatar,
            $rating,
            $description,
            $createdAt
        );
    }
}
