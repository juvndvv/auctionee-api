<?php

namespace App\Auction\Domain\Ports\Outbound;

use App\Auction\Domain\Models\Category;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Outbound\BaseRepositoryPort;

interface CategoryRepositoryPort extends BaseRepositoryPort
{
    /**
     * @param string $uuid
     * @return Category
     * @throws NotFoundException
     */
    public function findByUuid(string $uuid): Category;

    /**
     * @param string $uuid
     * @param string $name
     * @return mixed
     * @throws NotFoundException
     */
    public function updateName(string $uuid, string $name): void;
}
