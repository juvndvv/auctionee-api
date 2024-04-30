<?php

namespace App\Social\Domain\Resources;

class MessageResource
{
    public function __construct(
        public string $uuid,
        public string $message,
        public string $date
    )
    {}

    public static function create(string $uuid, string $message, string $date): self
    {
        return new self($uuid, $message, $date);
    }
}
