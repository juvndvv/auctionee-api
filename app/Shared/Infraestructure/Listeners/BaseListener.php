<?php

namespace App\Shared\Infraestructure\Listeners;

use App\Shared\Infraestructure\Bus\Command\CommandBus;

abstract class BaseListener
{
    public function __construct(
        protected readonly CommandBus $commandBus,
    )
    {}
}
