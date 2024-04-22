<?php

namespace App\UserManagement\Application\UpdateName;

use App\Shared\Domain\Bus\Events\EventBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use RuntimeException;

class UpdateNameCommandHandler
{
    public function __construct(private readonly EventBus $eventBus, private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateNameCommand $command): void
    {
        $uuid = $command->uuid();
        $name = $command->name();

        // Fetch data
        $dbUser = $this->userRepository->findByUuid($uuid);

        if (is_null($dbUser)) {
            throw new NotFoundException("El usuario con uuid $uuid no existe");
        }

        // Use case
        $user = User::fromPrimitives($dbUser->toArray());
        $user->updateName($name);

        $updates = $this->userRepository->updateName($uuid, $user->name());

        if ($updates < 1) {
            throw new RuntimeException("Ha ocurrido un error al actualizar el email");
        }

        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
