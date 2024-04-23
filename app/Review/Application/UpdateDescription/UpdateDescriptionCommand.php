<?php

namespace App\Review\Application\UpdateDescription;

class UpdateDescriptionCommand
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $description)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function description(): string
    {
        return $this->description;
    }
}
