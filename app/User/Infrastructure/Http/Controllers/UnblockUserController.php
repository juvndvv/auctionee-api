<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\CommandController;
use App\Shared\Infrastructure\Http\Controllers\Response;
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

            return Response::OK(
                data: $uuid,
                message: "Usuario desbloqueado"
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
