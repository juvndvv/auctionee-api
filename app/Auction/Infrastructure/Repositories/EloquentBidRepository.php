<?php

namespace App\Auction\Infrastructure\Repositories;

use App\Auction\Domain\Ports\Outbound\BidRepositoryPort;
use App\Auction\Infrastructure\Repositories\Models\EloquentBidModel;
use App\Shared\Infrastructure\Repositories\BaseRepository;

final class EloquentBidRepository extends BaseRepository implements BidRepositoryPort
{
    public const string ENTITY_NAME = 'bid';

    public function __construct()
    {
        parent::setModel(EloquentBidModel::query()->getModel());
        parent::setEntityName(self::ENTITY_NAME);
    }

    public function getTopBid(string $auctionUuid)
    {
        return EloquentBidModel::query()
            ->select('amount')
            ->where('auction_uuid', $auctionUuid)
            ->orderBy('amount', 'desc')
            ->limit(1)
            ->get()
        ;
    }
}
