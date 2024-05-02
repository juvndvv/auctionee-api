<?php

namespace App\Auction\Domain\Ports\Outbound;

use App\Auction\Domain\Models\Category\Category;
use App\Auction\Domain\Projections\CategoryProjection;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;
use Illuminate\Support\Collection;

interface CategoryRepositoryPort extends BaseRepositoryPort
{
    /**
     * @param int $offset
     * @param int $limit
     * @return Collection<CategoryProjection>
     * @throws NoContentException
     */
    public function findAll(int $offset = 0, int $limit = 20): Collection;

    /**
     * @param string $uuid
     * @return Category
     * @throws NotFoundException
     */
    public function findByUuid(string $uuid): Category;

    /**
     * @param string $uuid
     * @param string $name
     * @return void
     * @throws NotFoundException
     */
    public function updateName(string $uuid, string $name): void;

    /**
     * @param string $uuid
     * @param string $description
     * @return void
     * @throws NotFoundException
     */
    public function updateDescription(string $uuid, string $description): void;

    /**
     * @param string $uuid
     * @param string $avatar
     * @return void
     * @throws NotFoundException
     */
    public function updateAvatar(string $uuid, string $avatar): void;
}
