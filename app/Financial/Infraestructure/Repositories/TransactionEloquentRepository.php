<?php

namespace App\Financial\Infraestructure\Repositories;

use App\Financial\Domain\Models\Transaction;
use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Infraestructure\Repositories\Models\EloquentTransactionModel;
use App\Shared\Infraestructure\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class TransactionEloquentRepository extends BaseRepository implements TransactionRepositoryPort
{
    private const ENTITY_NAME = 'transaction';

    public function __construct()
    {
        $this->setEntityName(self::ENTITY_NAME);
        $this->setBuilderFromModel(EloquentTransactionModel::query()->getModel());
    }

    public function findByWalletUuid(string $walletUuid): Collection
    {
        $transactionsDb = EloquentTransactionModel::query()
            ->where(Transaction::SERIALIZED_REMITTENT_WALLET_UUID, $walletUuid)
            ->orWhere(Transaction::SERIALIZED_DESTINATION_WALLET_UUID, $walletUuid)
            ->get();

        return $transactionsDb->map(function (EloquentTransactionModel $transaction) {
            return Transaction::fromPrimitives($transaction->toArray());
        });
    }

    public function updateCollection(Collection $collection): void
    {
        $transactionsPrimitives = $collection
            ->map(function (Transaction $transaction) {
                return $transaction->toPrimitives();
            })->toArray();

        foreach ($transactionsPrimitives as $transactionPrimitive) {
            EloquentTransactionModel::query()
                ->where(Transaction::SERIALIZED_UUID, $transactionPrimitive[Transaction::SERIALIZED_UUID])
                ->update($transactionPrimitive);
        }
    }
}
