<?php declare(strict_types=1);

namespace App\Auction\Application\Commands\UpdateCategoryDescription;

use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;

final class UpdateCategoryDescriptionCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly CategoryRepositoryPort $categoryRepository
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateCategoryDescriptionCommand $command): void
    {
        $uuid = $command->uuid();
        $description = $command->description();

        $category = $this->categoryRepository->findByUuid($uuid);
        $category->updateDescription($description);

        $this->categoryRepository->updateDescription(
            $category->uuid(),
            $category->description()
        );
    }
}
