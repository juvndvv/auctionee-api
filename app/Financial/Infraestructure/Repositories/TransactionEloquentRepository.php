<?php

namespace App\Financial\Infraestructure\Repositories;

use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Infraestructure\Repositories\Models\EloquentTransactionModel;

class TransactionEloquentRepository implements TransactionRepositoryPort
{
    public function findByWalletUuid(string $walletUuid)
    {
        return EloquentTransactionModel::query()
            ->where("remitent_wallet_uuid", $walletUuid)
            ->orWhere("destination_wallet_uuid", $walletUuid)
            ->get();
    }

    public function create(array $data)
    {
        EloquentTransactionModel::query()->create($data);
    }
}
