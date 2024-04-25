<?php

namespace App\Shared\Infraestructure\Controllers;

use App\Shared\Infraestructure\Bus\Query\QueryBus;

abstract class QueryController extends BaseController
{
    public function __construct(protected readonly QueryBus $queryBus)
    {}
}
