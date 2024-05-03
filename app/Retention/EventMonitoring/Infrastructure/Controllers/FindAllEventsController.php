<?php

namespace App\Retention\EventMonitoring\Infrastructure\Controllers;

use App\Retention\EventMonitoring\Application\FindAll\FindAllEventsQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindAllEventsController extends QueryController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $offset = $request->input('page', 0) * env('PAGINATION_LIMIT');
            $limit = env('PAGINATION_LIMIT');

            $query = FindAllEventsQuery::create($offset, $limit);
            $resources = $this->queryBus->handle($query);

            return Response::OK($resources, "Eventos encontrados");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
