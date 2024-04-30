<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\CommandController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Application\Commands\DeleteUser\DeleteUserCommand;
use Exception;
use Illuminate\Http\JsonResponse;

final class DeleteUserController extends CommandController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $command = DeleteUserCommand::create($uuid);
            $this->commandBus->handle($command);

            return Response::OK($uuid, "Usuario borrado correctamente");

        } catch (NotFoundException) {
            return Response::NOT_FOUND("El usuario $uuid no existe");

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
