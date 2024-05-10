<?php

namespace App\Social\Domain\Resources;

use App\Social\Domain\Models\Message;

final class ChatRoomResource
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public MessageResource | null $lastMessage,
    )
    {}

    public static function create(string $uuid, string $name, string $avatar, MessageResource | null $lastMessage): self
    {
        return new self($uuid, $name, env('CLOUDFLARE_R2_URL') . $avatar, $lastMessage);
    }
}
