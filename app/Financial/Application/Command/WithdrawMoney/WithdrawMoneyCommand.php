<?php

namespace App\Financial\Application\Command\WithdrawMoney;

use App\Shared\Application\Commands\Command;

final class WithdrawMoneyCommand extends Command
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
