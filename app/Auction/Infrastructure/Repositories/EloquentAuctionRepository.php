<?php

namespace App\Auction\Infrastructure\Repositories;

use App\Auction\Domain\Models\Auction\Auction;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Domain\Projections\AuctionAndUserProjection;
use App\Auction\Domain\Projections\AuctionOverviewProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use Illuminate\Support\Collection;

final class EloquentAuctionRepository extends BaseRepository implements AuctionRepositoryPort
{
    public const string ENTITY_NAME = 'auction';

    public function __construct()
    {
        parent::setEntityName(self::ENTITY_NAME);
        parent::setModel(EloquentAuctionModel::query()->getModel());
    }

    public function findAll(int $offset = 0, int $limit = 0): Collection
    {
        $auctionsModels = EloquentAuctionModel::query()
            ->select([
                'auctions.uuid as uuid',
                'auctions.name as name',
                'auctions.description as description',
                'auctions.starting_price as price',
                'auctions.starting_date as date',
                'auctions.duration as duration',
                'auctions.avatar as avatar',
                'users.uuid as user_uuid',
                'users.username as user_username',
                'users.avatar as user_avatar',
            ])->join('users', 'users.uuid', '=', 'auctions.user_uuid')
        ->offset($offset)
        ->limit($limit)
        ->get();

        if ($auctionsModels->count() == 0) {
            throw new NoContentException("No hay subastas");
        }

        return $auctionsModels->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionAndUserProjection::fromPrimitives($auctionModel->toArray())
        );
    }

    public function findByUserUuid(string $uuid, int $offset, int $limit): Collection
    {
        $auctionModels = EloquentAuctionModel::query()
            ->select([
                'uuid',
                'name',
                'starting_price',
                'starting_date',
                'avatar'
            ])->where('user_uuid', $uuid)
            ->offset($offset)
            ->limit($limit)
            ->get();

        if ($auctionModels->count() == 0) {
            throw new NoContentException("No hay subastas");
        }

        return $auctionModels->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionOverviewProjection::fromPrimitives($auctionModel->toArray())
        );
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
