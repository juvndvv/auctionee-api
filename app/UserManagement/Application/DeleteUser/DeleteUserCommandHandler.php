<?php

namespace App\UserManagement\Application\DeleteUser;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Bus\Command\CommandHandler;
use App\Shared\Infraestructure\Bus\Events\EventBus;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;

class DeleteUserCommandHandler extends CommandHandler
{
    public function __construct(private readonly EventBus $eventBus, private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(DeleteUserCommand $command): void
    {
        $uuid = $command->uuid();

        // Fetch data
        $userDb = $this->userRepository->findByUuid($uuid);

        if (is_null($userDb)) {
            throw new NotFoundException("El usuario con uuid $uuid no existe");
        }

        // Use case
        $user = User::fromPrimitives($userDb->toArray());
        $user->delete();

        // Publish events
        $this->eventBus->dispatch(...$user->pullDomainEvents());

        // Persist
        $this->userRepository->delete($user->id());
    }
}
