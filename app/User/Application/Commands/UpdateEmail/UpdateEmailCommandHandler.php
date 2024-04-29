<?php

namespace App\User\Application\Commands\UpdateEmail;

use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infrastructure\Bus\EventBus;
use App\User\Domain\Ports\Outbound\UserRepositoryPort;

class UpdateEmailCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus           $eventBus,
        private readonly UserRepositoryPort $userRepository
    )
    {}

    public function __invoke(UpdateEmailCommand $command): void
    {
        $uuid = $command->uuid();
        $email = $command->email();

        $user = $this->userRepository->findByUuid($uuid);           // Query
        $user->updateEmail($email);                                 // Use case
        $this->userRepository->updateEmail($uuid, $user->email());  // Persistence
        $this->eventBus->dispatch(...$user->pullDomainEvents());    // Publish events
    }
}
