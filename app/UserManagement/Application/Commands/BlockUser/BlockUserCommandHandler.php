<?php

namespace App\UserManagement\Application\Commands\BlockUser;

use App\Shared\Infraestructure\Bus\Command\CommandHandler;
use App\Shared\Infraestructure\Bus\Events\EventBus;
use App\UserManagement\Domain\Models\User;
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
        $userDb = $this->userRepository->findByUuid($uuid);

        // Use case
        $user = User::fromPrimitives($userDb->toArray());
        $user->block();

        // Persistence
        $this->userRepository->block($uuid);

        // Dispatch event
        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
