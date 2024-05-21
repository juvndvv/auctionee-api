<?php

namespace App\Financial\Domain\Resources;

use App\Financial\Domain\Models\Wallet;

final class WalletResource
{
    public static function fromDomain(Wallet $wallet): array
    {
        return [
            'uuid' => $wallet->uuid(),
            'balance' => $wallet->balance(),
            'blocked_balance' => $wallet->blockedBalance(),
        ];
    }
}
