<?php

namespace App\User\Application\Commands\DeleteUser;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infrastructure\Bus\EventBus;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;

final class DeleteUserCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository,
        private readonly ImageRepositoryPort $imageRepository
    )
    {}

    /**
     * @param DeleteUserCommand $command
     * @throws NotFoundException
     */
    public function __invoke(DeleteUserCommand $command): void
    {
        // ANNOTATION: mejor en un servicio
        $uuid = $command->uuid();

        $user = $this->userRepository->findByUuid($uuid);

        $avatar = $user->avatar();
        $user->delete();

        $this->userRepository->deleteByPrimaryKey($uuid);

        if ($avatar !== env('DEFAULT_AVATAR')) {
            $this->imageRepository->delete($avatar);
        }
        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
