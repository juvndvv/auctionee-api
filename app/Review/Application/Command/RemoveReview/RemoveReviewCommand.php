<?php

namespace App\Review\Application\Command\RemoveReview;

use App\Shared\Application\Commands\Command;

final class RemoveReviewCommand extends Command
{
    private function __construct(
        private readonly string $uuid
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public static function create(string $uuid): RemoveReviewCommand
    {
        return new self($uuid);
    }
}
