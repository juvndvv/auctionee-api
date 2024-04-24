<?php

namespace App\Financial\Application\FindWalletByUserUuid;

use App\Shared\Domain\Bus\Query\Query;

class FindWalletByUserUuidQuery extends Query
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
