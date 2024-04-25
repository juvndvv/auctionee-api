<?php

namespace App\Financial\Application\WithdrawMoney;

use App\Shared\Application\Commands\Command;

class WithdrawMoneyCommand extends Command
{
    public function __construct(
        private readonly string $uuid,
        private readonly float $amount,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
