<?php

namespace App\Financial\Application\CreateWallet;

use App\Shared\Application\Command;

class CreateWalletCommand extends Command
{
    public function __construct(
        private readonly string $userUuid,
        private readonly float $amount = 0
    )
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
