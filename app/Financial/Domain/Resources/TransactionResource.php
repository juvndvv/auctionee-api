<?php

namespace App\Financial\Domain\Resources;

use App\Financial\Domain\Models\Transaction;

final class TransactionResource
{
    public static function fromDomain(Transaction $transaction, string $remittentWallet): array
    {
        return [
            'remittentWallet' => $transaction->remittentWalletUuid(),
            'destinationWallet' => $transaction->destinationWalletUuid(),
            'amount' => $transaction->amount()
        ];
    }
}
