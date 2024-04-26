<?php

namespace App\UserManagement\Application\Commands\UpdateUsername;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infraestructure\Bus\EventBus;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class UpdateUsernameCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository)
    {}

    public function __invoke(UpdateUsernameCommand $command): void
    {
        $uuid = $command->uuid();
        $username = $command->username();

        $user = $this->userRepository->findByUuid($uuid);                   // Query
        $user->updateUsername($username);                                   // Use case
        $this->userRepository->updateUsername($uuid, $user->username());    // Persistence
        $this->eventBus->dispatch(...$user->pullDomainEvents());            // Publish events
    }
}
