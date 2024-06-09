<?php

namespace App\Auction\Infrastructure\Repositories;

use App\Auction\Domain\Models\Auction\Auction;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Auction\Domain\Projections\AuctionAndUserProjection;
use App\Auction\Domain\Projections\AuctionDetailedProjection;
use App\Auction\Domain\Projections\AuctionOverviewProjection;
use App\Auction\Domain\Projections\BidDetailedProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentAuctionModel;
use App\Auction\Infrastructure\Repositories\Models\EloquentBidModel;
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
                'categories.uuid as category_uuid',
                'categories.name as category_name',
                'categories.avatar as category_avatar',
            ])->join('users', 'users.uuid', '=', 'auctions.user_uuid')
            ->join('categories', 'categories.uuid', '=', 'auctions.category_uuid')
        ->offset($offset)
        ->limit($limit)
        ->get();

        if ($auctionsModels->count() == 0) {
            throw new NoContentException("No hay subastas");
        }

        $auctions = [];

        for ($i = 0; $i < $auctionsModels->count(); $i++) {
            $bids = EloquentBidModel::query()
                ->select([
                    'bids.amount as amount',
                    'bids.created_at as date',
                    'users.avatar as user_avatar',
                    'users.username as username',
                ])
                ->join('users', 'users.uuid', '=', 'bids.user_uuid')
                ->where('auction_uuid', $auctionsModels[$i]->uuid)
                ->orderBy('amount', 'desc')
                ->get();

            $bids = $bids->map(
                fn (EloquentBidModel $bidModel) => BidDetailedProjection::fromPrivimites($bidModel->toArray())
            );
            $auction = AuctionDetailedProjection::fromPrimitives($auctionsModels[$i]->toArray(), $bids->toArray());
            $auctions[] = $auction;
        }

        return collect($auctions);
    }

    public function findByUserUuid(string $uuid): Collection
    {
        $auctionModels = EloquentAuctionModel::query()
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
                'categories.uuid as category_uuid',
                'categories.name as category_name',
                'categories.avatar as category_avatar',
            ])->join('users', 'users.uuid', '=', 'auctions.user_uuid')
            ->join('categories', 'categories.uuid', '=', 'auctions.category_uuid')
            ->where('user_uuid', $uuid)
            ->get();

        if ($auctionModels->count() == 0) {
            throw new NoContentException("No hay subastas");
        }

        return $auctionModels->map(
            fn (EloquentAuctionModel $auctionModel)
            =>
            AuctionAndUserProjection::fromPrimitives($auctionModel->toArray())
        );
    }

    public function findModelByUuid(string $uuid): Auction
    {
        $auctionModel = EloquentAuctionModel::query()
            ->where('uuid', $uuid)
            ->first();

        return Auction::fromPrimitives($auctionModel->toArray());
    }

    public function findByUuid(string $uuid): AuctionDetailedProjection
    {
        $auctionDb = EloquentAuctionModel::query()
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
                'categories.uuid as category_uuid',
                'categories.name as category_name',
                'categories.avatar as category_avatar',
            ])->join('users', 'users.uuid', '=', 'auctions.user_uuid')
            ->join('categories', 'categories.uuid', '=', 'auctions.category_uuid')
            ->where('auctions.uuid', $uuid)
            ->get();

        dd($auctionDb);

        $bids = EloquentBidModel::query()
            ->select([
                'bids.amount as amount',
                'bids.created_at as date',
                'users.avatar as user_avatar',
                'users.username as username',
            ])
            ->join('users', 'users.uuid', '=', 'bids.user_uuid')
            ->where('auction_uuid', $uuid)
            ->orderBy('amount', 'desc')
            ->get();

        $bids = $bids->map(
            fn (EloquentBidModel $bidModel) => BidDetailedProjection::fromPrivimites($bidModel->toArray())
        );

        return AuctionDetailedProjection::fromPrimitives($auctionDb->toArray(), $bids->toArray());
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
