<?php

namespace App\Financial\Application\Command\MakeTransaction;

use App\Shared\Application\Commands\Command;

final class MakeTransactionCommand extends Command
{
    public function __construct(
        private readonly string $remittentWallet,
        private readonly string $destinationWallet,
        private readonly float  $amount
    )
    {}

    public function remittentWallet(): string
    {
        return $this->remittentWallet;
    }

    public function destinationWallet(): string
    {
        return $this->destinationWallet;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
