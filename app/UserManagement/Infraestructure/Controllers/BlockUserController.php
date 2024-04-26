<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Infraestructure\Controllers\CommandController;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\Commands\BlockUser\BlockUserCommand;
use Illuminate\Http\Request;

final class BlockUserController extends CommandController
{
    public function __invoke(string $uuid)
    {
        $command = BlockUserCommand::create($uuid);
        $this->commandBus->handle($command);
        return Response::OK($uuid, "Usuario bloqueado correctamente.");
    }
}
