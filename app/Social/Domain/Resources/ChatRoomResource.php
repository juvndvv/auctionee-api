<?php

namespace App\Social\Domain\Resources;

final class ChatRoomResource
{
    public function __construct(
        public string $uuid,
        public string $username,
        public string $avatar
    )
    {}

    public static function create(string $uuid, string $username, string $avatar): self
    {
        return new self($uuid, $username, $avatar);
    }
}
