<?php

namespace App\Auction\Application\Command\UpdateName;

use App\Auction\Domain\Models\Category;
use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;

final class UpdateNameCommandHandler extends CommandHandler
{
    public function __construct(
        private CategoryRepositoryPort $categoryRepository
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateNameCommand $command): void
    {
        $uuid = $command->uuid();
        $name = $command->name();

        $category = $this->categoryRepository->findByUuid($uuid);
        $category->updateName($name);

        $this->categoryRepository->updateName($uuid, $name);
    }
}
