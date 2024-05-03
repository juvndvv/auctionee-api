<?php

namespace App\Financial\Application\Command\CreateWallet;

use App\Shared\Application\Commands\Command;

final class CreateWalletCommand extends Command
{
    public function __construct(
        private readonly string $userUuid,
        private readonly float  $balance = 0,
        private readonly float $blockedBalance = 0
    )
    {}

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function balance(): float
    {
        return $this->balance;
    }

    public function blockedAmount(): float
    {
        return $this->blockedBalance;
    }
}
