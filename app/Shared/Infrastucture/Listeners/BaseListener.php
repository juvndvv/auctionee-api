<?php

namespace App\Shared\Infrastucture\Listeners;

use App\Shared\Infrastucture\Bus\CommandBus;

abstract class BaseListener
{
    public function __construct(
        protected readonly CommandBus $commandBus,
    )
    {}
}
