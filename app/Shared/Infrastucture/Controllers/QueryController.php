<?php

namespace App\Shared\Infrastucture\Controllers;

use App\Shared\Infrastucture\Bus\QueryBus;

abstract class QueryController extends BaseController
{
    public function __construct(
        protected readonly QueryBus $queryBus
    )
    {}
}
