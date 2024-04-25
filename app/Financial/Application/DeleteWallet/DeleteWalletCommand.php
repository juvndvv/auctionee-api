<?php

namespace App\Financial\Application\DeleteWallet;

use App\Shared\Application\Commands\Command;

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
