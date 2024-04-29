<?php

namespace App\Financial\Application\Command\DeleteWallet;

use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Domain\Services\DeleteWalletService;
use App\Shared\Application\Commands\CommandHandler;

final class DeleteWalletCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort       $walletRepository,
        private readonly TransactionRepositoryPort  $transactionRepository
    )
    {}

    public function __invoke(DeleteWalletCommand $command): void
    {
        $userUuid = $command->userUuid();

        // Query wallet
        $wallet = $this->walletRepository->findByUserUuid($userUuid);
        $transactions = $this->transactionRepository->findByWalletUuid($wallet->uuid());
        $wallet->setTransactions($transactions);

        // Invoke the service
        DeleteWalletService::execute($wallet);

        // Persist data
        $this->transactionRepository->updateCollection($wallet->transactions());
        $this->walletRepository->deleteByPrimaryKey($wallet->uuid());
    }
}
