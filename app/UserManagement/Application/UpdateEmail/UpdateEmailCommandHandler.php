<?php

namespace App\UserManagement\Application\UpdateEmail;

use App\Shared\Domain\Bus\Events\EventBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use RuntimeException;

class UpdateEmailCommandHandler
{
    public function __construct(private readonly EventBus $eventBus, private readonly UserRepositoryPort $userRepository)
    {}

    public function __invoke(UpdateEmailCommand $command): void
    {
        $uuid = $command->uuid();
        $email = $command->email();

        // Fetch data
        $dbUser = $this->userRepository->findByUuid($uuid);

        if (is_null($dbUser)) {
            throw new NotFoundException("El usuario con uuid $uuid no existe");
        }

        // Use case
        $user = User::fromPrimitives($dbUser->toArray());
        $user->updateEmail($email);

        // Persistence
        $updates = $this->userRepository->updateEmail($uuid, $user->email());

        if ($updates < 1) {
            throw new RuntimeException("Ha ocurrido un error al actualizar el email");
        }

        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
