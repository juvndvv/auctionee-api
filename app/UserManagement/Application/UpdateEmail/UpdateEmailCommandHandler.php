<?php

namespace App\UserManagement\Application\UpdateEmail;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\UserManagement\Domain\Ports\Outbound\UserRepositoryPort;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class UpdateEmailCommandHandler
{
    public function __construct(private readonly UserRepositoryPort $userRepository)
    {}

    public function __invoke(UpdateEmailCommand $command): void
    {
        try {
            $uuid = $command->uuid();
            $email = $command->email();

            $updates = $this->userRepository->updateEmail($uuid, $email);

            if ($updates < 1) {
                throw new RuntimeException("Ha ocurrido un error al actualizar el email");
            }

        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("El usuario con uuid $uuid no existe");
        }
    }
}
