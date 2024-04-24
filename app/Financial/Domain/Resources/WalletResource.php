<?php

namespace App\Financial\Domain\Resources;

use App\Financial\Domain\Models\Wallet;

class WalletResource
{
    public static function fromDomain(Wallet $wallet): array
    {
        return [
            'uuid' => $wallet->uuid(),
            'amount' => $wallet->amount(),
        ];
    }
}