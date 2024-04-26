<?php

namespace App\User\Infraestructure\Controllers;

use App\Shared\Infraestructure\Controllers\CommandController;
use App\Shared\Infraestructure\Controllers\Response;
use App\User\Application\Commands\BlockUser\BlockUserCommand;

final class BlockUserController extends CommandController
{
    public function __invoke(string $uuid)
    {
        $command = BlockUserCommand::create($uuid);
        $this->commandBus->handle($command);
        return Response::OK($uuid, "Usuario bloqueado correctamente.");
    }
}
