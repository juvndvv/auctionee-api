<?php

namespace App\Financial\Domain\Models;

use App\Financial\Domain\Models\ValueObjects\TransactionAmount;
use App\Financial\Domain\Models\ValueObjects\WalletUuid;

class Transaction
{
    private WalletUuid $destinationWalletUuid;
    private TransactionAmount $amount;

    public function __construct(string $destinationWalletUuid, float $amount)
    {
        $this->destinationWalletUuid = new WalletUuid($destinationWalletUuid);
        $this->amount = new TransactionAmount($amount);
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['destination_wallet_uuid'],
            $data['amount']
        );
    }

    public function toPrimitives(): array
    {
        return [
            $this->destinationWalletUuid->value(),
            $this->amount->value(),
        ];
    }

    public function destinationWalletUuid(): string
    {
        return $this->destinationWalletUuid->value();
    }

    public function amount(): float
    {
        return $this->amount->value();
    }
}
