<?php

namespace App\Social\Domain\Resources;

final class ChatRoomResource
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar
    )
    {}

    public static function create(string $uuid, string $name, string $avatar): self
    {
        return new self($uuid, $name, env('CLOUDFLARE_R2_URL') . $avatar);
    }
}
