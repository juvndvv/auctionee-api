<?php

namespace App\User\Infrastructure\Controllers;

use App\Shared\Infrastucture\Controllers\CommandController;
use App\Shared\Infrastucture\Controllers\Response;
use App\User\Application\Commands\UnblockUser\UnblockUserCommand;
use Exception;
use Illuminate\Http\JsonResponse;

final class UnblockUserController extends CommandController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $command = UnblockUserCommand::create($uuid);
            $this->commandBus->handle($command);

            return Response::OK($uuid, "Usuario desbloqueado correctamente.");

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
