<?php

namespace App\Financial\Application\Query\FindTransactionsByWalletUuid;

use App\Shared\Application\Queries\Query;

final class FindTransactionsByWalletUuidQuery extends Query
{
    public function __construct(
        private readonly string $walletUuid
    )
    {}

    public function walletUuid(): string
    {
        return $this->walletUuid;
    }
}
