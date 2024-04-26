<?php

namespace App\UserManagement\Application\Commands\UnblockUser;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infraestructure\Bus\EventBus;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class UnblockUserCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository
    )
    {}

    public function __invoke(UnblockUserCommand $command): void
    {
        $uuid = $command->uuid();

        // Retrieve from db
        $user = $this->userRepository->findByUuid($uuid);
        $user->unblock();

        // Persistence
        $this->userRepository->unblock($uuid);

        // Dispatch event
        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
