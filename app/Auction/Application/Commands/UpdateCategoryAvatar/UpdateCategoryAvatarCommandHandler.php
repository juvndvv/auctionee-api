<?php declare(strict_types=1);

namespace App\Auction\Application\Commands\UpdateCategoryAvatar;

use App\Auction\Domain\Ports\Outbound\CategoryRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;

final class UpdateCategoryAvatarCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly CategoryRepositoryPort $categoryRepository,
        private readonly ImageRepositoryPort $imageRepository
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateCategoryAvatarCommand $command): void
    {
        $uuid = $command->uuid();
        $avatar = $command->avatar();

        // Query data
        $category = $this->categoryRepository->findByUuid($uuid);
        $old = $category->avatar();

        // Delete previous image
        $this->imageRepository->delete($old);

        // Store new image
        $new = $this->imageRepository->store('categories', $avatar);

        $category->updateAvatar($new);

        $this->categoryRepository->updateAvatar($uuid, $new);
    }
}
