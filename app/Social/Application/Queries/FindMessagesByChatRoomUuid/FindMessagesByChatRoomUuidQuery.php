<?php

namespace App\Social\Application\Queries\FindMessagesByChatRoomUuid;


use App\Shared\Application\Queries\Query;

final class FindMessagesByChatRoomUuidQuery extends Query
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $token,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function token(): string
    {
        return $this->token;
    }

    public static function create(string $uuid, string $token): self
    {
        return new self($uuid, $token);
    }
}
