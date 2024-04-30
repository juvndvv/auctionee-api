<?php declare(strict_types=1);

namespace App\Auction\Infrastructure\Repositories;

use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;
use App\Shared\Infrastructure\Repositories\BaseRepository;

class EloquentCategoryRepository extends BaseRepository implements CategoryRepositoryPort
{
    public const string ENTITY_NAME = 'category';

    public function __construct()
    {
        parent::setEntityName(self::ENTITY_NAME);
        parent::setModel(EloquentCategoryModel::query()->getModel());
    }
}
