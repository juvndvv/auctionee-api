<?php

namespace App\Financial\Application\Command\MakeTransaction;

use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infrastucture\Bus\EventBus;

class MakeTransactionCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository,
        private readonly TransactionRepositoryPort $transactionRepository,
        private readonly EventBus $eventBus
    )
    {}

    public function __invoke(MakeTransactionCommand $command): void
    {
        $remitentWalletUuid = $command->remitentWallet();
        $destinationWalletUuid = $command->destinationWallet();
        $amount = $command->amount();

        // Fetch data
        $remitentWallet = $this->walletRepository->findByUuid($remitentWalletUuid);
        $destinationWallet = $this->walletRepository->findByUuid($destinationWalletUuid);

        // Make de transaction
        $remitentWallet->makeTransaction($destinationWalletUuid, $amount);
        $remitentWallet->withdraw($amount);
        $destinationWallet->deposit($amount);

        // Get the results
        $transaction = $remitentWallet->transactions()->get(0);

        // Persists
        $this->transactionRepository->create($remitentWalletUuid, $transaction);
        $this->walletRepository->withdraw($remitentWalletUuid, $amount);
        $this->walletRepository->deposit($destinationWalletUuid, $amount);

        // Publish events
        $this->eventBus->dispatch(...$remitentWallet->pullDomainEvents());
    }
}
