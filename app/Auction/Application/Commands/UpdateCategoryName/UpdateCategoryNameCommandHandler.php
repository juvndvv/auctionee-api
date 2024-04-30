<?php

namespace App\Auction\Application\Commands\UpdateCategoryName;

use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;

final class UpdateCategoryNameCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly CategoryRepositoryPort $categoryRepository
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateCategoryNameCommand $command): void
    {
        $uuid = $command->uuid();
        $name = $command->name();

        $category = $this->categoryRepository->findByUuid($uuid);
        $category->updateName($name);

        $this->categoryRepository->updateName($uuid, $name);
    }
}
