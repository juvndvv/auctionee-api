<?php

namespace App\Review\Application\RemoveReview;

use App\Shared\Application\Commands\Command;

class RemoveReviewCommand extends Command
{
    public function __construct(private readonly  string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
