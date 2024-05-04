<?php

namespace App\Review\Infrastructure\Http\Controllers;

use App\Review\Application\Query\FindUserReviews\FindUserReviewsQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindUserReviewsController extends QueryController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $offset = $request->input('page', 0) * env('PAGINATION_LIMIT');
            $limit = env('PAGINATION_LIMIT');

            $query = FindUserReviewsQuery::create($uuid, $offset, $limit);
            $resource = $this->queryBus->handle($query);

            return Response::OK(
                data: $resource,
                message:  "Reviews encontradas"
            );

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
