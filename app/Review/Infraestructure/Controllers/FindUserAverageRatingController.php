<?php

namespace App\Review\Infraestructure\Controllers;

use App\Review\Application\FindUserAverage\FindUserAverageQuery;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\Response;

class FindUserAverageRatingController
{
    public function __construct(private readonly QueryBus $queryBus)
    {}

    public function __invoke(string $uuid)
    {
        $avg = $this->queryBus->handle(new FindUserAverageQuery($uuid));
        return Response::OK($avg);
    }
}
