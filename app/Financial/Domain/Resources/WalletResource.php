<?php

namespace App\Financial\Domain\Resources;

use App\Financial\Domain\Models\Wallet;

class WalletResource
{
    public function __construct(
        private readonly string $uuid,
        private readonly float $amount,
    )
    {}

    public static function fromDomain(Wallet $wallet): WalletResource
    {
        return new self(
            $wallet->uuid(),
            $wallet->amount(),
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'amount' => $this->amount,
        ];
    }
}
