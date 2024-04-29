<?php

namespace App\Shared\Infrastructure\Controllers;

use App\Shared\Infrastructure\Bus\QueryBus;

abstract class QueryController extends BaseController
{
    public function __construct(
        protected readonly QueryBus $queryBus
    )
    {}
}
