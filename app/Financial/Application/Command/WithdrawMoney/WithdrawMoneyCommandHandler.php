<?php

namespace App\Financial\Application\Command\WithdrawMoney;

use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Domain\Services\TransactorService;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infrastructure\Bus\EventBus;


final class WithdrawMoneyCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository,
        private readonly TransactionRepositoryPort  $transactionRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotEnoughFoundsException
     */
    public function __invoke(WithdrawMoneyCommand $command): void
    {
        $remittentWalletUuid = $command->uuid();
        $destinationWalletUuid = env('AUCTIONEE_WALLET');
        $amount = $command->amount();

        $service = TransactorService::create(
            $remittentWalletUuid,
            $destinationWalletUuid,
            $amount,
            $this->walletRepository
        );
        $remittentWallet = $service->execute();

        // Persists
        $transaction = $remittentWallet->transactions()->get(0);
        $this->transactionRepository->create($transaction->toPrimitives());
        $this->walletRepository->updateAmount($destinationWalletUuid, 999999);

        // Publish events
        $this->eventBus->dispatch(...$remittentWallet->pullDomainEvents());
    }
}
