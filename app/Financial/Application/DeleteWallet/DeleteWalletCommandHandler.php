<?php

namespace App\Financial\Application\DeleteWallet;

use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Domain\Services\DeleteWalletService;
use App\Shared\Application\Commands\CommandHandler;

class DeleteWalletCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort       $walletRepository,
        private readonly TransactionRepositoryPort  $transactionRepository
    )
    {}

    public function __invoke(DeleteWalletCommand $command): void
    {
        $userUuid = $command->userUuid();

        $wallet = $this->walletRepository->findByUserUuid($userUuid);
        $transactions = $this->transactionRepository->findByWalletUuid($wallet->uuid());
        $wallet->setTransactions($transactions);

        $service = DeleteWalletService::create($this->walletRepository, $this->transactionRepository);
        $service->execute($wallet);
    }
}
