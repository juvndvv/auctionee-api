<?php

namespace App\Financial\Application\DeleteWallet;

use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Infraestructure\Bus\Command\CommandHandler;

class DeleteWalletCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository
    )
    {}

    public function __invoke(DeleteWalletCommand $command): void
    {
        $uuid = $command->uuid();
        $this->walletRepository->delete($uuid);
    }
}
