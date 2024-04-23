<?php

namespace App\Review\Application\UpdateRating;

class UpdateRatingCommand
{
    public function __construct(
        private readonly string $uuid,
        private readonly int $rating)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function rating(): string
    {
        return $this->rating;
    }
}
