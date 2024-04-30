<?php declare(strict_types=1);

namespace App\Auction\Application\Commands\CreateCategory;

use App\Auction\Domain\Models\Category;
use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;

final class CreateCategoryCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly CategoryRepositoryPort $categoryRepository
    )
    {}

    public function __invoke(CreateCategoryCommand $command): void
    {
        $name = $command->name();
        $description = $command->description();
        $avatar = $command->avatar();

        $category = Category::create($name, $description, $avatar);
        $this->categoryRepository->create($category->toPrimitives());
    }
}
