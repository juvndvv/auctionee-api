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

            return Response::OK(
                data: $uuid,
                message: "Usuario borrado correctamente"
            );

        } catch (NotFoundException) {
            return Response::NOT_FOUND(
                message: "El usuario $uuid no existe"
            );

        } catch (Exception $e) {
            return Response::SERVER_ERROR($e);
        }
    }
}
