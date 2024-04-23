<?php

namespace App\Review\Application\RemoveReview;

class RemoveReviewCommand
{
    public function __construct(private readonly  string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
