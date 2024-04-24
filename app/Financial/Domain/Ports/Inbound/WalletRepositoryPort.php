<?php

namespace App\Financial\Domain\Ports\Inbound;

use App\Financial\Domain\Models\Wallet;

interface WalletRepositoryPort
{
    /**
     * @param Wallet $wallet
     * @return void
     */
    public function create(Wallet $wallet): void;

    /**
     * @param string $uuid
     * @return void
     */
    public function delete(string $uuid): void;

    /**
     * @param string $userUuid
     * @return Wallet
     */
    public function findByUserUuid(string $userUuid): Wallet;

    /**
     * @param string $uuid
     * @return Wallet
     */
    public function findByUuid(string $uuid): Wallet;

    /**
     * @param string $uuid
     * @return bool
     */
    public function existsByUuid(string $uuid): bool;

    public function withdraw(string $uuid, float $amount): void;

    public function deposit(string $uuid, float $amount): void;

    public function findAmountByUuid(string $uuid): float;
}
