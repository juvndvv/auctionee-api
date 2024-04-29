<?php

namespace App\Financial\Domain\Services;

use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Financial\Domain\Models\Transaction;
use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;

final readonly class TransactorService
{
    private function __construct(
        private string               $remittentWalletUuid,
        private string               $destinationWalletUuid,
        private float                $amount,
        private WalletRepositoryPort $walletRepository,
    )
    {}

    /**
     * @throws NotEnoughFoundsException
     */
    public function execute(): Wallet
    {
        // Query data
        $remittentWallet = $this->walletRepository->findByUuid($this->remittentWalletUuid);
        $destinationWallet = $this->walletRepository->findByUuid($this->destinationWalletUuid);

        // Use case
        $remittentWallet->makeTransaction($this->destinationWalletUuid, $this->amount);
        $remittentWallet->withdraw($this->amount);
        $destinationWallet->deposit($this->amount);

        // Update wallets
        $this->walletRepository->updateAmount($remittentWallet->uuid(), $remittentWallet->amount());
        $this->walletRepository->updateAmount($destinationWallet->uuid(), $destinationWallet->amount());

        return $remittentWallet;
    }

    public static function create(
        string                  $remittentWalletUuid,
        string                  $destinationWalletUuid,
        float                   $amount,
        WalletRepositoryPort    $walletRepository
    ): self
    {
        return new self(
            $remittentWalletUuid,
            $destinationWalletUuid,
            $amount,
            $walletRepository
        );
    }
}
