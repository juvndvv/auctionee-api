<?php

namespace App\Auction\Domain\Ports\Outbound;

use App\Auction\Domain\Models\Auction\Auction;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;

interface AuctionRepositoryPort extends BaseRepositoryPort
{

    /**
     * @throws NotFoundException
     */
    public function findByUuid(string $uuid): Auction;

    /**
     * @throws NotFoundException
     */
    public function updateAvatar(string $uuid, string $avatar): void;
}
