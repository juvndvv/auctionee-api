<?php

namespace App\User\Infrastructure\Controllers;

use App\Shared\Infrastucture\Controllers\CommandController;
use App\Shared\Infrastucture\Controllers\Response;
use App\User\Application\Commands\UnblockUser\UnblockUserCommand;

final class UnblockUserController extends CommandController
{
    public function __invoke(string $uuid)
    {
        $command = UnblockUserCommand::create($uuid);
        $this->commandBus->handle($command);
        return Response::OK($uuid, "Usuario desbloqueado correctamente.");
    }
}
