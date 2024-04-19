<?php

namespace App\UserManagement\Application\UpdateUsername;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use RuntimeException;

class UpdateUsernameCommandHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateUsernameCommand $command): void
    {
        $uuid = $command->uuid();
        $username = $command->username();

        // Fetch data
        $dbUser = $this->userRepository->findByUuid($uuid);

        if (is_null($dbUser)) {
            throw new NotFoundException("El usuario con uuid $uuid no existe");
        }

        // Use case
        $user = User::fromPrimitives($dbUser->toArray());
        $user->updateUsername($username);

        $updates = $this->userRepository->updateUsername($uuid, $user->username());

        if ($updates < 1) {
            throw new RuntimeException("Ha ocurrido un error al actualizar el email");
        }
    }
}
