<?php

namespace App\Financial\Domain\Ports\Inbound;

interface WalletRepositoryPort
{
    public function create(array $data);
    public function delete(array $data);
    public function findWalletByUserUuid(string $userUuid);
}
