<?php

namespace App\Financial\Infrastructure\Repositories;

use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Infrastructure\Repositories\Models\EloquentWalletModel;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Repositories\BaseRepository;

final class EloquentWalletRepository extends BaseRepository implements WalletRepositoryPort
{
    private const string ENTITY_NAME = 'wallet';

    public function __construct()
    {
        $this->setModel(EloquentWalletModel::query()->getModel());
        $this->setEntityName(self::ENTITY_NAME);
    }

    /**
     * @throws NotFoundException
     */
    public function findByUserUuid(string $userUuid): Wallet
    {
        $walletDb = parent::findByFieldValue(Wallet::USER_UUID, $userUuid);
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
        return parent::existsByFieldValue(Wallet::UUID, $uuid);
    }

    /**
     * @throws NotFoundException
     */
    public function updateAmount(string $uuid, float $amount): void
    {
        parent::updateFieldByPrimaryKey($uuid, Wallet::BALANCE, $amount);
    }

    public function findAmountByUuid(string $uuid): float
    {
        return EloquentWalletModel::query()
            ->select(Wallet::BALANCE)
            ->where(Wallet::UUID, $uuid)
            ->first()
            ->getAttribute(Wallet::BALANCE);
    }

    public function blockAmount(string $uuid, float $amount): void
    {
        $walletDb = EloquentWalletModel::query()
            ->select([Wallet::BALANCE, Wallet::BLOCKED_BALANCE])
            ->where(Wallet::UUID, $uuid)->firstOrFail();

        $balance = $walletDb->getAttribute(Wallet::BALANCE);

        if ($balance < $amount) {
            throw new NotEnoughFoundsException("No hay fondos suficientes");
        }

        $blockedBalance = $walletDb->getAttribute(Wallet::BLOCKED_BALANCE);

        $walletDb->update([
            Wallet::BALANCE => $balance - $amount,
        ]);

        $walletDb->update([
            Wallet::BLOCKED_BALANCE => $blockedBalance + $amount
        ]);
    }

    public function updateBlockedAmount(string $uuid, float $amount): void
    {
        EloquentWalletModel::query()
            ->where(Wallet::UUID, $uuid)
            ->firstOrFail()
        ->update([
            Wallet::BLOCKED_BALANCE => $amount,
        ]);
    }

    public function unblockAmount(string $uuid, float $amount): void
    {
        $walletDb = EloquentWalletModel::query()
            ->select([Wallet::BALANCE, Wallet::BLOCKED_BALANCE])
            ->where(Wallet::UUID, $uuid)->firstOrFail();

        $balance = $walletDb->getAttribute(Wallet::BALANCE);
        $blockedBalance = $walletDb->getAttribute(Wallet::BLOCKED_BALANCE);

        $walletDb->update([
            Wallet::BALANCE => $balance + $amount,
            Wallet::BLOCKED_BALANCE => $blockedBalance - $amount
        ]);
    }
}
