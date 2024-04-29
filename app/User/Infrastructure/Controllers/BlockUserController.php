<?php

namespace App\User\Infrastructure\Controllers;

use App\Shared\Infrastructure\Controllers\CommandController;
use App\Shared\Infrastructure\Controllers\Response;
use App\User\Application\Commands\BlockUser\BlockUserCommand;
use Exception;
use Illuminate\Http\JsonResponse;

final class BlockUserController extends CommandController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
        $command = BlockUserCommand::create($uuid);
        $this->commandBus->handle($command);
        return Response::OK($uuid, "Usuario bloqueado correctamente.");

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }

    }
}
