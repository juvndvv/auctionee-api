<?php

namespace App\Financial\Application\Command\CreateWallet;

use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;

final class CreateWalletCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository
    )
    {}

    public function __invoke(CreateWalletCommand $command): void
    {
        $balance = $command->balance();
        $blockedBalance  = $command->blockedAmount();
        $userUuid = $command->userUuid();

        $wallet = Wallet::create($balance, $blockedBalance, $userUuid);
        $this->walletRepository->create($wallet->toPrimitives());
    }
}
