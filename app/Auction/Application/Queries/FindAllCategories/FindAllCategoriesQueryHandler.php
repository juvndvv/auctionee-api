<?php declare(strict_types=1);

namespace App\Auction\Application\Queries\FindAllCategories;

use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Shared\Application\Commands\QueryHandler;
use App\Shared\Domain\Exceptions\NoContentException;
use Illuminate\Support\Collection;

class FindAllCategoriesQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly CategoryRepositoryPort $categoryRepository
    )
    {}

    /**
     * @throws NoContentException
     */
    public function __invoke(FindAllCategoriesQuery $query): Collection
    {
        return $this->categoryRepository->findAll();
    }
}
