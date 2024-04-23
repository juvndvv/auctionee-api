<?php

namespace App\Financial\Domain\Ports\Inbound;

use App\Financial\Domain\Models\Transaction;

interface TransactionRepositoryPort
{
    public function findByWalletUuid(string $walletUuid);
    public function create(array $data);
}
