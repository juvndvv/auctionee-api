<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\CommandController;
use App\Shared\Infrastructure\Http\Controllers\Response;
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
            return Response::OK(
                data: $uuid,
                message: "Usuario bloqueado correctamente."
            );

        } catch (NotFoundException $exception) {
            return Response::NOT_FOUND(
                message: $exception->getMessage()
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
