<?php

namespace App\Review\Infraestructure\Controllers;

use App\Review\Application\FindUserReviews\FindUserReviewsQuery;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\Response;

class FindUserReviewsController
{

    public function __construct(private readonly QueryBus $queryBus)
    {}

    public function __invoke(string $uuid)
    {
        $query = new FindUserReviewsQuery($uuid);

        $resource = $this->queryBus->handle($query);

        return Response::OK($resource, "Reviews encontradas");
    }
}
