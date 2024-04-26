<?php

namespace App\Social\Application\Queries\FindFriendListByUserUuid;

use App\Shared\Infraestructure\Bus\Query\Query;

class FindFriendListByUserUuidQuery extends Query
{
    public function __construct(
        private readonly string $userUuid
    )
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public static function create(string $userUuid): FindFriendListByUserUuidQuery
    {
        return new self($userUuid);
    }
}
