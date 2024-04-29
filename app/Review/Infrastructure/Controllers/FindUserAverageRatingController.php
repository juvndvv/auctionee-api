<?php

namespace App\Review\Infrastructure\Controllers;

use App\Review\Application\Query\FindUserAverage\FindUserAverageQuery;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Controllers\QueryController;
use App\Shared\Infrastructure\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindUserAverageRatingController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $avg = $this->queryBus->handle(new FindUserAverageQuery($uuid));
            return Response::OK($avg);

        } catch (NotFoundException $exception) {
            return Response::NOT_FOUND($exception->getMessage());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
