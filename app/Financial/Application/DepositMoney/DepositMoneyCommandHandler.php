<?php

namespace App\Financial\Application\DepositMoney;

use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Infraestructure\Bus\Command\CommandHandler;

class DepositMoneyCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository
    )
    {}

    public function __invoke(DepositMoneyCommand $command)
    {
        $walletUuid = $command->walletUuid();
        $amount = $command->amount();

        $wallet = $this->walletRepository->findByUuid($walletUuid);
        $wallet->deposit($amount);

        $this->walletRepository->deposit($walletUuid, $amount);
    }
}
