<?php

namespace App\Social\Domain\Resources;

class MessageResource
{
    public function __construct(
        public string $uuid,
        public string $message,
        public string $date,
        public string $senderUuid,
    )
    {}

    public static function create(string $uuid, string $message, string $date, string $senderUuid): self
    {
        return new self($uuid, $message, $date, $senderUuid);
    }
}
