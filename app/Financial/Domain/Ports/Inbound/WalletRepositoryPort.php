<?php

namespace App\Financial\Domain\Ports\Inbound;

use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Financial\Domain\Models\Wallet;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface WalletRepositoryPort extends BaseRepositoryPort
{
    /**
     * @param string $userUuid
     * @return Wallet
     * @throws ModelNotFoundException
     */
    public function findByUserUuid(string $userUuid): Wallet;

    /**
     * @param string $uuid
     * @return Wallet
     * @throws ModelNotFoundException
     */
    public function findByUuid(string $uuid): Wallet;

    /**
     * @param string $uuid
     * @return bool
     */
    public function existsByUuid(string $uuid): bool;

    /**
     * @param string $uuid
     * @param float $amount
     * @return void
     * @throws ModelNotFoundException
     */
    public function updateAmount(string $uuid, float $amount): void;

    /**
     * @param string $uuid
     * @param float $amount
     * @return void
     * @throws NotEnoughFoundsException
     */
    public function updateBlockedAmount(string $uuid, float $amount): void;

    public function updateUnblockedAmount(string $uuid, float $amount): void;

    /**
     * @param string $uuid
     * @param float $amount
     * @return void
     * @throws NotEnoughFoundsException
     */
    public function unblockAmount(string $uuid, float $amount): void;

    /**
     * Busca la columna <i>amount</i> por la clave primaria
     *
     * @param string $uuid
     * @return float
     */
    public function findAmountByUuid(string $uuid): float;
}
