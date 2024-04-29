<?php

namespace App\Financial\Domain\Services;

use App\Financial\Domain\Models\Transaction;
use App\Financial\Domain\Models\Wallet;
use App\Financial\Domain\Ports\Inbound\TransactionRepositoryPort;
use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;

final class DeleteWalletService
{
    public const DELETED_WALLET_UUID = 'WD000000-0000-0000-0000-000000000000';

    /**
     * Recorre transacciones y cambia el valor del uuid de la wallet que se va a eliminar a
     * el valor de la wallet que hace referencia a usuario eliminado
     *
     * @param Wallet $wallet
     * @return void
     */
    public static function execute(Wallet $wallet): void
    {
        $deletingWalletUuid = $wallet->uuid();
        $transactions = $wallet->transactions();

        $newTransactions = $transactions->map(
            function (Transaction $transaction) use ($deletingWalletUuid) {
                   if ($transaction->remittentWalletUuid() == $deletingWalletUuid) {
                       $transaction->updateRemittent(self::DELETED_WALLET_UUID);

                   } elseif ($transaction->destinationWalletUuid() == $deletingWalletUuid) {
                       $transaction->updateDestination(self::DELETED_WALLET_UUID);
                   }

                   return $transaction;
        });

        $wallet->setTransactions($newTransactions);
    }
}
