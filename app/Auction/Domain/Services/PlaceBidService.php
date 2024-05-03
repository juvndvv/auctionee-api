<?php

namespace App\Auction\Domain\Services;

final class PlaceBidService
{
    public static function execute(): void
    {
        /*
         * 1. Bloquear el dinero de la wallet
         * 2. Desbloquear el dinero de la puja anterior
         * 3. Insertar la puja
         */
    }
}
