<?php

namespace App\Financial\Application\Command\WithdrawMoney;

use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;


final class WithdrawMoneyCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository
    )
    {}

    /**
     * @throws NotEnoughFoundsException
     */
    public function __invoke(WithdrawMoneyCommand $command): void
    {
        $uuid = $command->uuid();
        $amount = $command->amount();

        $wallet = $this->walletRepository->findByUuid($uuid);
        $wallet->withdraw($amount);

        $this->walletRepository->updateAmount($uuid, $wallet->balance());
    }
}
