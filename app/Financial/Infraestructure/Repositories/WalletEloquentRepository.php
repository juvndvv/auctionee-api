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
    public function findWalletByUserUuid(string $userUuid): Wallet
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
}
