<?php

namespace App\Auction\Domain\Ports\Outbound;

use App\Auction\Domain\Models\Auction\Auction;
use App\Auction\Domain\Projections\AuctionAndUserProjection;
use App\Auction\Domain\Projections\AuctionDetailedProjection;
use App\Auction\Domain\Projections\AuctionOverviewProjection;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Support\Collection;

interface AuctionRepositoryPort extends BaseRepositoryPort
{
    /**
     * @param int $offset
     * @param int $limit
     * @return Collection<AuctionAndUserProjection>
     * @throws NoContentException
     */
    public function findAll(int $offset = 0, int $limit = 0): Collection;

    /**
     * @param string $uuid
     * @return Collection<AuctionOverviewProjection>
     * @throws NoContentException
     */
    public function findByUserUuid(string $uuid): Collection;

    public function findModelByUuid(string $uuid): Auction;

    /**
     * @throws NotFoundException
     */
    public function findByUuid(string $uuid): AuctionDetailedProjection;

    /**
     * @throws NotFoundException
     */
    public function updateAvatar(string $uuid, string $avatar): void;

    /**
     * @throws NotFoundException
     */
    public function updateName(string $uuid, string $name): void;

    /**
     * @throws NotFoundException
     */
    public function updateDescription(string $uuid, string $description): void;

    /**
     * @throws NotFoundException
     */
    public function updateStartingPrice(string $uuid, float $startingPrice): void;

    /**
     * @throws NotFoundException
     */
    public function updateStartingDate(string $uuid, string $startingDate): void;

    /**
     * @throws NotFoundException
     */
    public function updateDuration(string $uuid, int $duration): void;
}
