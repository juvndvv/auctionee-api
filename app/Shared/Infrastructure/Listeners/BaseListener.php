<?php

namespace App\Shared\Infrastructure\Listeners;

use App\Shared\Infrastructure\Bus\CommandBus;

abstract class BaseListener
{
    public function __construct(
        protected readonly CommandBus $commandBus,
    )
    {}
}
