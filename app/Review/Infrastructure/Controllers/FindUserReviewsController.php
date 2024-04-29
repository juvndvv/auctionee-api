<?php

namespace App\Review\Infrastructure\Controllers;

use App\Review\Application\Query\FindUserReviews\FindUserReviewsQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastucture\Controllers\QueryController;
use App\Shared\Infrastucture\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindUserReviewsController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $query = FindUserReviewsQuery::create($uuid);
            $resource = $this->queryBus->handle($query);

            return Response::OK($resource, "Reviews encontradas");

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
