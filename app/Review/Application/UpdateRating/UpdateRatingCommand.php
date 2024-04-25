<?php

namespace App\Review\Application\UpdateRating;

use App\Shared\Infraestructure\Bus\Command\Command;

class UpdateRatingCommand extends Command
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
