<?php

namespace App\Review\Infraestructure\Controllers;

use App\Review\Application\Query\FindUserReviews\FindUserReviewsQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;

final class FindUserReviewsController extends QueryController
{
    public function __invoke(string $uuid)
    {
        try {
            $query = new FindUserReviewsQuery($uuid);
            $resource = $this->queryBus->handle($query);

            return Response::OK($resource, "Reviews encontradas");

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
