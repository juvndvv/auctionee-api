<?php

namespace App\Financial\Domain\Ports\Inbound;

use App\Financial\Domain\Models\Transaction;
use Illuminate\Support\Collection;

interface TransactionRepositoryPort
{
    /**
     * @param string $walletUuid
     * @return Collection<Transaction>
     */
    public function findByWalletUuid(string $walletUuid): Collection;

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function create(Transaction $transaction): void;
}
