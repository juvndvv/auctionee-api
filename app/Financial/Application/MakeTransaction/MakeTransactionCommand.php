<?php

namespace App\Financial\Application\MakeTransaction;

use App\Shared\Domain\Bus\Command\Command;

class MakeTransactionCommand extends Command
{
    public function __construct(
        private readonly string $remitentWallet,
        private readonly string $destinationWallet,
        private readonly float $amount
    )
    {}

    public function remitentWallet(): string
    {
        return $this->remitentWallet;
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
