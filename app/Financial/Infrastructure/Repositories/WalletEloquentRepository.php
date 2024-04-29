<?php

namespace App\Financial\Infrastructure\Repositories;

use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Infrastructure\Repositories\Models\EloquentWalletModel;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Repositories\BaseRepository;

final class WalletEloquentRepository extends BaseRepository implements WalletRepositoryPort
{
    private const string ENTITY_NAME = 'wallet';

    public function __construct()
    {
        $this->setBuilderFromModel(EloquentWalletModel::query()->getModel());
        $this->setEntityName(self::ENTITY_NAME);
    }

    /**
     * @throws NotFoundException
     */
    public function findByUserUuid(string $userUuid): Wallet
    {
        $walletDb = parent::findByFieldValue(Wallet::SERIALIZED_USER_UUID, $userUuid);
        return Wallet::fromPrimitives($walletDb->toArray()['0']);
    }

    /**
     * @throws NotFoundException
     */
    public function findByUuid(string $uuid): Wallet
    {
        $walletDb = parent::findOneByPrimaryKeyOrFail($uuid);
        return Wallet::fromPrimitives($walletDb->toArray());
    }

    public function existsByUuid(string $uuid): bool
    {
        return parent::existsByFieldValue(Wallet::SERIALIZED_UUID, $uuid);
    }

    /**
     * @throws NotFoundException
     */
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
