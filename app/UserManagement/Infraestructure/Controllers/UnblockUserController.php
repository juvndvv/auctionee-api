<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\UnblockUser\UnblockUserCommand;

class UnblockUserController
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke(string $uuid)
    {
        $command = new UnblockUserCommand($uuid);
        $this->commandBus->handle($command);
        return Response::OK($uuid, "Usuario desbloqueado correctamente.");
    }
}
