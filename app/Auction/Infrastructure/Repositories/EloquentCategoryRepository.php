<?php declare(strict_types=1);

namespace App\Auction\Infrastructure\Repositories;

use App\Auction\Domain\Models\Category\Category;
use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Auction\Domain\Projections\CategoryProjection;
use App\Auction\Infrastructure\Repositories\Models\EloquentCategoryModel;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use Illuminate\Support\Collection;

final class EloquentCategoryRepository extends BaseRepository implements CategoryRepositoryPort
{
    public const string ENTITY_NAME = 'category';

    public function __construct()
    {
        parent::setEntityName(self::ENTITY_NAME);
        parent::setModel(EloquentCategoryModel::query()->getModel());
    }

    public function findAll(int $offset = 0, int $limit = 20): Collection
    {
        $categoriesDb = parent::findAll($offset, $limit);

        return $categoriesDb->map(
            fn (EloquentCategoryModel $category) => CategoryProjection::create(
                $category->uuid,
                $category->name,
                $category->description,
                $category->avatar
            )
        );
    }

    public function findByUuid(string $uuid): Category
    {
        $categoryDb = parent::findOneByPrimaryKeyOrFail($uuid);
        return Category::fromPrimitives($categoryDb->toArray());
    }

    public function updateName(string $uuid, string $name): void
    {
        parent::updateFieldByPrimaryKey($uuid, Category::SERIALIZED_NAME, $name);
    }

    public function updateDescription(string $uuid, string $description): void
    {
        parent::updateFieldByPrimaryKey($uuid, Category::SERIALIZED_DESCRIPTION, $description);
    }

    public function updateAvatar(string $uuid, string $avatar): void
    {
        parent::updateFieldByPrimaryKey($uuid, Category::SERIALIZED_AVATAR, $avatar);
    }
}
