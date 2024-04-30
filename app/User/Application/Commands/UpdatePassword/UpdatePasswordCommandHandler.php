<?php

namespace App\User\Application\Commands\UpdatePassword;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Bus\EventBus;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;

final class UpdatePasswordCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdatePasswordCommand $command): void
    {
        $uuid = $command->uuid();
        $name = $command->password();

        $user = $this->userRepository->findByUuid($uuid);                   // Query
        $user->updatePassword($name);                                       // Use case
        $this->userRepository->updatePassword($uuid, $user->password());    // Persistence
        $this->eventBus->dispatch(...$user->pullDomainEvents());            // Publish event
    }
}
