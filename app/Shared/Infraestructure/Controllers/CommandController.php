<?php

namespace App\Shared\Infraestructure\Controllers;

use App\Shared\Infraestructure\Bus\Command\CommandBus;

class CommandController extends BaseController
{
    public function __construct(
        protected readonly CommandBus $commandBus
    )
    {}
}
