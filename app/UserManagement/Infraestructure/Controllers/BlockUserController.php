<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Infraestructure\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\BlockUser\BlockUserCommand;

class BlockUserController
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke(string $uuid)
    {
        $command = new BlockUserCommand($uuid);
        $this->commandBus->handle($command);
        return Response::OK($uuid, "Usuario bloqueado correctamente.");
    }
}
