<?php

namespace App\Financial\Application\DeleteWallet;

use App\Shared\Domain\Bus\Command\Command;

class DeleteWalletCommand extends Command
{
    public function __construct(
        private readonly string $uuid,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }
}
