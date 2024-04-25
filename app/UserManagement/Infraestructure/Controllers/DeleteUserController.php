<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\DeleteUser\DeleteUserCommand;
use Exception;

class DeleteUserController
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke(string $uuid)
    {
        try {
            $command = new DeleteUserCommand($uuid);
            $this->commandBus->handle($command);

            return Response::OK($uuid, "Usuario borrado correctamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND("El usuario $uuid no existe");

        } catch (Exception $e) {
            dd($e);
            return Response::SERVER_ERROR();
        }
    }
}
