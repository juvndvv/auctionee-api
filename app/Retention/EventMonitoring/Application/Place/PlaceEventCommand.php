<?php

namespace App\Retention\EventMonitoring\Application\Place;

class PlaceEventCommand
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $type,
        private readonly string $message,
        private readonly string $ocurredOn)
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function ocurredOn(): string
    {
        return $this->ocurredOn;
    }
}
