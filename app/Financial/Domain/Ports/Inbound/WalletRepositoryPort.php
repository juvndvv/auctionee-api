<?php

namespace App\Financial\Domain\Ports\Inbound;

use App\Financial\Domain\Models\Wallet;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface WalletRepositoryPort extends BaseRepositoryPort
{
    /**
     * @param string $userUuid
     * @return Model<Wallet>
     * @throws ModelNotFoundException
     */
    public function findByUserUuid(string $userUuid): Wallet;

    /**
     * @param string $uuid
     * @return Model<Wallet>
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
     * Busca la columna <i>amount</i> por la clave primaria
     *
     * @param string $uuid
     * @return float
     */
    public function findAmountByUuid(string $uuid): float;
}
