<?php

namespace App\Review\Application\Command\UpdateDescription;

use App\Shared\Application\Commands\Command;

final class UpdateDescriptionCommand extends Command
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $description
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function description(): string
    {
        return $this->description;
    }

    public static function create(string $uuid, string $description): UpdateDescriptionCommand
    {
        return new self($uuid, $description);
    }
}
