<?php

namespace App\Review\Infrastructure\Controllers;

use App\Review\Application\Query\FindUserAverage\FindUserAverageQuery;
use App\Shared\Infrastucture\Controllers\QueryController;
use App\Shared\Infrastucture\Controllers\Response;
use Illuminate\Http\JsonResponse;

final class FindUserAverageRatingController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        $avg = $this->queryBus->handle(new FindUserAverageQuery($uuid));
        return Response::OK($avg);
    }
}
