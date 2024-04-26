<?php

namespace App\Financial\Infraestructure\Repositories;

use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Infraestructure\Repositories\Models\EloquentWalletModel;
use App\Shared\Infraestructure\Repositories\BaseRepository;

class WalletEloquentRepository extends BaseRepository implements WalletRepositoryPort
{
private const ENTITY_NAME = 'wallet';

    public function __construct()
    {
        $this->setBuilderFromModel(EloquentWalletModel::query()->getModel());
        $this->setEntityName(self::ENTITY_NAME);
    }

    public function findByUserUuid(string $userUuid): Wallet
    {
        $walletDb = parent::findByFieldValue(Wallet::SERIALIZED_USER_UUID, $userUuid);
        return Wallet::fromPrimitives($walletDb->toArray()['0']);
    }

    public function findByUuid(string $uuid): Wallet
    {
        $walletDb = parent::findOneByPrimaryKeyOrFail($uuid);
        return Wallet::fromPrimitives($walletDb->toArray());
    }

    public function existsByUuid(string $uuid): bool
    {
        return parent::existsByFieldValue(Wallet::SERIALIZED_UUID, $uuid);
    }

    public function updateAmount(string $uuid, float $amount): void
    {
        parent::updateFieldByPrimaryKey($uuid, Wallet::SERIALIZED_AMOUNT, $amount);
    }

    public function findAmountByUuid(string $uuid): float
    {
        return EloquentWalletModel::query()
            ->select('amount')
            ->where('uuid', $uuid)
            ->first()
            ->getAttribute('amount');
    }
}
