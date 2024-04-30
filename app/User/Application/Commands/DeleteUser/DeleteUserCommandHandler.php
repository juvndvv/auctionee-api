<?php

namespace App\User\Application\Commands\DeleteUser;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;

final class DeleteUserCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @param DeleteUserCommand $command
     * @throws NotFoundException
     */
    public function __invoke(DeleteUserCommand $command): void
    {
        $uuid = $command->uuid();

        $user = $this->userRepository->findByUuid($uuid);
        $user->delete();

        $this->userRepository->deleteByPrimaryKey($uuid);

        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}