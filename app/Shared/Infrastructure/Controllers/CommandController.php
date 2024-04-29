<?php

namespace App\Shared\Infrastructure\Controllers;

use App\Shared\Infrastructure\Bus\CommandBus;

class CommandController extends BaseController
{
    public function __construct(
        protected readonly CommandBus $commandBus
    )
    {}
}
