<?php

namespace App\Financial\Domain\Ports\Inbound;

use App\Financial\Domain\Models\Transaction;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface TransactionRepositoryPort extends BaseRepositoryPort
{
    /**
     * Busca las transacciones de una wallet
     *
     * @param string $walletUuid
     * @return Collection<Transaction>
     * @throws NotFoundException
     */
    public function findByWalletUuid(string $walletUuid): Collection;

    /**
     * Actualiza una colección
     *
     * @param Collection $collection
     * @return void
     */
    public function updateCollection(Collection $collection): void;
}
