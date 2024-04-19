<?php

namespace App\UserManagement\Application\UpdateName;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class UpdateNameCommandHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateNameCommand $command): void
    {
        try {
            $uuid = $command->uuid();
            $name = $command->name();

            $updates = $this->userRepository->updateName($uuid, $name);

            if ($updates < 1) {
                throw new RuntimeException("Ha ocurrido un error al actualizar el email");
            }

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("El usuario con uuid $uuid no existe");
        }
    }
}
