<?php

namespace App\Financial\Infrastructure\Repositories;

use App\Financial\Domain\Models\Transaction;
use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Infrastructure\Repositories\Models\EloquentTransactionModel;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use Illuminate\Support\Collection;

final class EloquentTransactionRepository extends BaseRepository implements TransactionRepositoryPort
{
    private const string ENTITY_NAME = 'transaction';

    public function __construct()
    {
        $this->setEntityName(self::ENTITY_NAME);
        $this->setModel(EloquentTransactionModel::query()->getModel());
    }

    public function findByWalletUuid(string $walletUuid): Collection
    {
        $transactionsDb = EloquentTransactionModel::query()
            ->where(Transaction::SERIALIZED_REMITTENT_WALLET_UUID, $walletUuid)
            ->orWhere(Transaction::SERIALIZED_DESTINATION_WALLET_UUID, $walletUuid)
            ->get();

        if ($transactionsDb->count() == 0) {
            throw new NotFoundException("No existe la wallet con uuid $walletUuid");
        }

        return $transactionsDb->map(
            fn (EloquentTransactionModel $transaction) => Transaction::fromPrimitives($transaction->toArray())
        );
    }

    public function updateCollection(Collection $collection): void
    {
        $transactionsPrimitives = $collection
            ->map(fn (Transaction $transaction) => $transaction->toPrimitives())
            ->toArray();

        foreach ($transactionsPrimitives as $transactionPrimitive) {
            EloquentTransactionModel::query()
                ->where(Transaction::SERIALIZED_UUID, $transactionPrimitive[Transaction::SERIALIZED_UUID])
                ->update($transactionPrimitive);
        }
    }
}
