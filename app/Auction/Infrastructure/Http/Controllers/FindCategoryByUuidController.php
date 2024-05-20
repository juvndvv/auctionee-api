<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Shared\Infrastructure\Http\Controllers\Response;

class FindCategoryByUuidController
{
    public function __construct(private readonly CategoryRepositoryPort $categoryRepository)
    {
    }

    public function __invoke(string $uuid)
    {
        $category = $this->categoryRepository->findByUuid($uuid);
        return Response::OK($category, 'Categoria encontrada');
    }
}
