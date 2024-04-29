<?php

namespace App\Financial\Application\Command\DepositMoney;

use App\Shared\Application\Commands\Command;

final class DepositMoneyCommand extends Command
{
    public function __construct(
        private readonly string $walletUuid,
        private readonly float  $amount
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
