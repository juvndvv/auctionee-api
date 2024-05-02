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
}
