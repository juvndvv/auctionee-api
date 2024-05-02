<?php

namespace App\Auction\Infrastructure\Repositories;

use App\Auction\Domain\Models\Auction\Auction;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Infrastructure\Repositories\BaseRepository;

final class EloquentAuctionRepository extends BaseRepository implements AuctionRepositoryPort
{
    public const string ENTITY_NAME = 'auction';

    public function __construct()
    {
        parent::setEntityName(self::ENTITY_NAME);
        parent::setModel(EloquentAuctionModel::query()->getModel());
    }

    public function findByUuid(string $uuid): Auction
    {
        $auctionDb = parent::findOneByPrimaryKeyOrFail($uuid);
        return Auction::fromPrimitives($auctionDb->toArray());
    }

    public function updateAvatar(string $uuid, string $avatar): void
    {
        parent::updateFieldByPrimaryKey($uuid, Auction::AVATAR, $avatar);
    }

    public function updateName(string $uuid, string $name): void
    {
        parent::updateFieldByPrimaryKey($uuid, Auction::NAME, $name);
    }

    public function updateDescription(string $uuid, string $description): void
    {
        parent::updateFieldByPrimaryKey($uuid, Auction::DESCRIPTION, $description);
    }

    public function updateStartingPrice(string $uuid, float $startingPrice): void
    {
        parent::updateFieldByPrimaryKey($uuid, Auction::STARTING_PRICE, $startingPrice);
    }

    public function updateStartingDate(string $uuid, string $startingDate): void
    {
        parent::updateFieldByPrimaryKey($uuid, Auction::STARTING_DATE, $startingDate);
    }

    public function updateDuration(string $uuid, int $duration): void
    {
        parent::updateFieldByPrimaryKey($uuid, Auction::DURATION, $duration);
    }
}
