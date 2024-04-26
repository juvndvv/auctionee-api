<?php

namespace App\Financial\Application\Query\WithdrawMoney;

use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;

class WithdrawMoneyCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository
    )
    {}

    public function __invoke(WithdrawMoneyCommand $command)
    {
        $uuid = $command->uuid();
        $amount = $command->amount();

        $wallet = $this->walletRepository->findByUuid($uuid);
        $wallet->withdraw($amount);

        $this->walletRepository->withdraw($uuid, $amount);
    }
}
