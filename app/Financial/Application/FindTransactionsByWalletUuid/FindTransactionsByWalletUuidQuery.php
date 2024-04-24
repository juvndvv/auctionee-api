<?php

namespace App\Financial\Application\FindTransactionsByWalletUuid;

use App\Shared\Domain\Bus\Query\Query;

class FindTransactionsByWalletUuidQuery extends Query
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
