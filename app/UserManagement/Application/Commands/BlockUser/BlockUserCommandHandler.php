<?php

namespace App\UserManagement\Application\Commands\BlockUser;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infraestructure\Bus\EventBus;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class BlockUserCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository
    )
    {}

    public function __invoke(BlockUserCommand $command)
    {
        $uuid = $command->uuid();

        // Retrieve from db
        $user = $this->userRepository->findByUuid($uuid);
        $user->block();

        // Persistence
        $this->userRepository->block($uuid);

        // Dispatch event
        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
