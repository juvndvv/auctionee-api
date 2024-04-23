<?php

namespace App\Financial\Infraestructure\Repositories;

use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Infraestructure\Repositories\Models\EloquentWalletModel;

class WalletEloquentRepository implements WalletRepositoryPort
{
    public function create(array $data)
    {
        EloquentWalletModel::query()->create($data);
    }

    public function delete(array $data)
    {
        EloquentWalletModel::query()->findOrFail($data['id'])->delete();
    }

    public function findWalletByUserUuid(string $userUuid)
    {
        return EloquentWalletModel::query()->findOrFail($userUuid);
    }
}
