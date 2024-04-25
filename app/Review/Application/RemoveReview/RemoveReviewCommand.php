<?php

namespace App\Review\Application\RemoveReview;

use App\Shared\Infraestructure\Bus\Command\Command;

class RemoveReviewCommand extends Command
{
    public function __construct(private readonly  string $uuid)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
