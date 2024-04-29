<?php

namespace App\Financial\Application\Query\FindWalletByUserUuid;

use App\Shared\Application\Queries\Query;

final class FindWalletByUserUuidQuery extends Query
{
    public function __construct(
        private readonly string $userUuid
    )
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }
}
