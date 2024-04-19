<?php

namespace App\UserManagement\Application\UpdatePassword;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Application\UpdateName\UpdateNameCommand;
use App\UserManagement\Domain\Models\User;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use RuntimeException;

class UpdatePasswordCommandHandler extends CommandHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    public function __invoke(UpdatePasswordCommand $command): void
    {
        $uuid = $command->uuid();
        $name = $command->password();

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
    }
}
