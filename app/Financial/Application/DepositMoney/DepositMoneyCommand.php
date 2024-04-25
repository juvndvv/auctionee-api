<?php

namespace App\Financial\Application\DepositMoney;

use App\Shared\Application\Commands\Command;

class DepositMoneyCommand extends Command
{
    public function __construct(
        private readonly string $walletUuid,
        private readonly float $amount
    )
    {}

    public function walletUuid(): string
    {
        return $this->walletUuid;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
