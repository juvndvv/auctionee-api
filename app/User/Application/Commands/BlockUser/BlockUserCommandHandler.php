<?php

namespace App\User\Application\Commands\BlockUser;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infrastucture\Bus\EventBus;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;

final class BlockUserCommandHandler extends CommandHandler
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
