<?php

namespace App\Social\Application\Queries\FindChatRoomsByUserUuid;

use App\Shared\Application\Queries\Query;

final class FindChatRoomsByUserUuidQuery extends Query
{
    private function __construct(
        private readonly string $uuid
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public static function create(string $uuid): self
    {
        return new self($uuid);
    }
}
