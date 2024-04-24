<?php

namespace App\Financial\Infraestructure\Repositories;

use App\Financial\Domain\Models\Transaction;
use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Infraestructure\Repositories\Models\EloquentTransactionModel;
use Illuminate\Support\Collection;

class TransactionEloquentRepository implements TransactionRepositoryPort
{
    /**
     * @param string $walletUuid
     * @return Collection<Transaction>
     */
    public function findByWalletUuid(string $walletUuid): Collection
    {
        $transactionsDb = EloquentTransactionModel::query()
            ->where('wallet_uuid', $walletUuid)
            ->get()
            ->toArray();

        return Transaction::getCollectionFromPrimitivesArray($transactionsDb);
    }

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function create(string $remitentUuid, Transaction $transaction): void
    {
        $transactionDb = $transaction->toPrimitives($remitentUuid);
        EloquentTransactionModel::query()->create($transactionDb);
    }
}
