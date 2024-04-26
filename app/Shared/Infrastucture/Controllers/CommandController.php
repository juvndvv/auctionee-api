<?php

namespace App\Shared\Infrastucture\Controllers;

use App\Shared\Infrastucture\Bus\CommandBus;

class CommandController extends BaseController
{
    public function __construct(
        protected readonly CommandBus $commandBus
    )
    {}
}
