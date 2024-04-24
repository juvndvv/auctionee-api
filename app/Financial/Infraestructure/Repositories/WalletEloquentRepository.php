<?php

namespace App\Financial\Infraestructure\Repositories;

use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Infraestructure\Repositories\Models\EloquentWalletModel;
use App\Shared\Domain\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WalletEloquentRepository implements WalletRepositoryPort
{
    /**
     * @param Wallet $wallet
     * @return void
     */
    public function create(Wallet $wallet): void
    {
        $walletDb = $wallet->toPrimitives();
        EloquentWalletModel::query()->create($walletDb);
    }

    /**
     * @param string $uuid
     * @return void
     * @throws NotFoundException
     */
    public function delete(string $uuid): void
    {
        try {
            EloquentWalletModel::query()->findOrFail($uuid)->delete();

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("Wallet no encontrada");
        }

    }

    /**
     * @param string $userUuid
     * @return Wallet
     * @throws NotFoundException
     */
    public function findByUserUuid(string $userUuid): Wallet
    {
        try {
            $walletDb = EloquentWalletModel::query()
                ->where('user_uuid', $userUuid)
                ->firstOrFail();
            return Wallet::fromPrimitives($walletDb->toArray());

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("Wallet no encontrada");
        }
    }

    /**
     * @param string $uuid
     * @return Wallet
     * @throws NotFoundException
     */
    public function findByUuid(string $uuid): Wallet
    {
        try {
            $walletDb = EloquentWalletModel::query()
                ->where('uuid', $uuid)
                ->firstOrFail();
            return Wallet::fromPrimitives($walletDb->toArray());

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("Wallet no encontrada");
        }
    }

    /**
     * @param string $uuid
     * @return bool
     */
    public function existsByUuid(string $uuid): bool
    {
        return EloquentWalletModel::query()
            ->where('uuid', $uuid)
            ->exists();
    }

    /**
     * @param string $uuid
     * @param float $amount
     * @return void
     */
    public function withdraw(string $uuid, float $amount): void
    {
        $currentAmount = self::findAmountByUuid($uuid);

        EloquentWalletModel::query()
            ->where('uuid', $uuid)
            ->firstOrFail()
            ->update(['amount' => $currentAmount - $amount]);
    }

    /**
     * @param string $uuid
     * @param float $amount
     * @return void
     */
    public function deposit(string $uuid, float $amount): void
    {
        $currentAmount = self::findAmountByUuid($uuid);

        EloquentWalletModel::query()
            ->where('uuid', $uuid)
            ->firstOrFail()
            ->update(['amount' => $currentAmount + $amount]);    }

    /**
     * @param string $uuid
     * @return float
     */
    public function findAmountByUuid(string $uuid): float
    {
        return EloquentWalletModel::query()
            ->select('amount')
            ->where('uuid', $uuid)
            ->first()
            ->getAttribute('amount');
    }
}
