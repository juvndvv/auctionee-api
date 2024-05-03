<?php

namespace App\Financial\Domain\Services;

use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;

final class WithdrawnService
{
    public string $adminWalletUuid;

    private function __construct(
        private readonly string               $remittentWallet,
        private readonly float                         $amount,
        private readonly WalletRepositoryPort $walletRepository,
    )
    {
        $this->adminWalletUuid = '';
    }

    /**
     * @throws NotEnoughFoundsException
     */
    public function execute(): Wallet
    {
        // Query data
        $adminWallet = $this->walletRepository->findByUuid($this->adminWalletUuid);
        $remittentWallet = $this->walletRepository->findByUuid($this->remittentWallet);

        // Use case
        $remittentWallet->makeTransaction($this->adminWalletUuid, $this->amount);
        $remittentWallet->withdraw($this->amount);
        $adminWallet->deposit($this->amount);

        // Update wallets
        $this->walletRepository->updateAmount($remittentWallet->uuid(), $remittentWallet->balance());
        $this->walletRepository->updateAmount($adminWallet->uuid(), $adminWallet->balance());

        return $remittentWallet;
    }

    public static function create(
        string               $remittentWalletUuid,
        float                $amount,
        WalletRepositoryPort $walletRepository,
    ): self
    {
        return new self($remittentWalletUuid, $amount, $walletRepository);
    }
}
