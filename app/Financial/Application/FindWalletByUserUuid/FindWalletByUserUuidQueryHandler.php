<?php

namespace App\Financial\Application\FindWalletByUserUuid;

use App\Financial\Domain\Ports\Inbound\WalletRepositoryPort;
use App\Financial\Domain\Resources\WalletResource;
use App\Shared\Infraestructure\Bus\Query\QueryHandler;

class FindWalletByUserUuidQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly WalletRepositoryPort $walletRepository
    )
    {}

    public function __invoke(FindWalletByUserUuidQuery $query): array
    {
        $userUuid = $query->userUuid();
        $wallet = $this->walletRepository->findByUserUuid($userUuid);
        return WalletResource::fromDomain($wallet);
    }
}
