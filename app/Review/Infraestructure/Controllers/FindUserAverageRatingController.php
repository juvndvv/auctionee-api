<?php

namespace App\Review\Infraestructure\Controllers;

use App\Review\Application\Query\FindUserAverage\FindUserAverageQuery;
use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;

final class FindUserAverageRatingController extends QueryController
{
    public function __invoke(string $uuid)
    {
        $avg = $this->queryBus->handle(new FindUserAverageQuery($uuid));
        return Response::OK($avg);
    }
}
