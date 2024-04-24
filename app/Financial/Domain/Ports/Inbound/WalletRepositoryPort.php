<?php

namespace App\Financial\Domain\Ports\Inbound;

use App\Financial\Domain\Models\Wallet;

interface WalletRepositoryPort
{
    /**
     * @param Wallet $data
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
    public function findWalletByUserUuid(string $userUuid): Wallet;
}
