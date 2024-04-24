<?php

namespace App\Financial\Domain\Resources;

use App\Financial\Domain\Models\Transaction;

class TransactionResource
{
    public static function fromDomain(Transaction $transaction, string $remitentWallet)
    {
        return [
            'remitent_wallet' => $remitentWallet,
            'destination_wallet' => $transaction->destinationWalletUuid(),
            'amount' => $transaction->amount()
        ];
    }
}
