<?php

namespace App\Financial\Application\Query\FindTransactionsByWalletUuid;

use App\Financial\Domain\Models\Transaction;
use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Resources\TransactionResource;
use App\Shared\Application\Commands\QueryHandler;

class FindTransactionsByWalletUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly TransactionRepositoryPort $transactionRepository
    )
    {}

    /**
     * @param FindTransactionsByWalletUuidQuery $query
     * @return array
     */
    public function __invoke(FindTransactionsByWalletUuidQuery $query): array
    {
        $walletUuid = $query->walletUuid();
        $transactions = $this->transactionRepository->findByWalletUuid($walletUuid);

        return array_map(
            function (Transaction $transaction) use ($walletUuid) {
                return TransactionResource::fromDomain($transaction, $walletUuid);
            }, $transactions->toArray());
    }
}
