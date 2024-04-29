<?php

namespace App\Review\Application\Command\UpdateRating;

use App\Shared\Application\Commands\Command;

final class UpdateRatingCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly int    $rating
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function rating(): string
    {
        return $this->rating;
    }

    public static function create(string $uuid, int $rating): UpdateRatingCommand
    {
        return new self($uuid, $rating);
    }
}
