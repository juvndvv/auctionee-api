<?php

namespace App\Financial\Application\Query\FindWalletByUserUuid;

use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Shared\Application\Commands\QueryHandler;

final class FindWalletByUserUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository
    )
    {}

    public function __invoke(FindWalletByUserUuidQuery $query): array
    {
        $userUuid = $query->userUuid();
        $wallet = $this->walletRepository->findByUserUuid($userUuid);
        return $wallet->toPrimitives();
    }
}
