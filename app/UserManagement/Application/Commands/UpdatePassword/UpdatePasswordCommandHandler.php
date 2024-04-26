<?php

namespace App\UserManagement\Application\Commands\UpdatePassword;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infraestructure\Bus\EventBus;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class UpdatePasswordCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository
    )
    {}

    public function __invoke(UpdatePasswordCommand $command): void
    {
        $uuid = $command->uuid();
        $name = $command->password();

        $user = $this->userRepository->findByUuid($uuid);               // Query
        $user->updatePassword($name);                                   // Use case
        $this->userRepository->updatePassword($uuid, $user->name());    // Persistence
        $this->eventBus->dispatch(...$user->pullDomainEvents());        // Publish event
    }
}
