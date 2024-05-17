<?php

namespace App\Review\Domain\Projections;

final class ReviewDetailsProjection
{
    public function __construct(
        public string   $uuid,
        public string $reviewerUuid,
        public string   $reviewerUsername,
        public string   $reviewerAvatar,
        public int      $rating,
        public string   $description,
        public string   $createdAt
    )
    {}

    public static function create(
        string  $uuid,
        string $reviewerUuid,
        string  $reviewerUsername,
        string  $reviewerAvatar,
        int     $rating,
        string  $description,
        string  $createdAt
    ): self
    {
        return new self(
            $uuid,
            $reviewerUuid,
            $reviewerUsername,
            env('CLOUDFLARE_R2_URL') . $reviewerAvatar,
            $rating,
            $description,
            $createdAt
        );
    }
}
