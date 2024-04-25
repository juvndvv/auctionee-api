<?php

namespace App\UserManagement\Application\UnblockUser;

use App\Shared\Infraestructure\Bus\Command\CommandHandler;
use App\Shared\Infraestructure\Bus\Events\EventBus;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class UnblockUserCommandHandler extends CommandHandler
{
    public function __construct(private readonly EventBus $eventBus, private UserRepositoryPort $userRepository)
    {
    }

    public function __invoke(UnblockUserCommand $command)
    {
        $uuid = $command->uuid();

        // Retrieve from db
        $userDb = $this->userRepository->findByUuid($uuid);

        // Use case
        $user = User::fromPrimitives($userDb->toArray());
        $user->unblock();

        // Persistence
        $this->userRepository->unblock($uuid);

        // Dispatch event
        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
