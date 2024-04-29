<?php

namespace App\Retention\EventMonitoring\Infrastructure\Controllers;

use App\Retention\EventMonitoring\Application\FindAll\FindAllEventsQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Controllers\QueryController;
use App\Shared\Infrastructure\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindAllEventsController extends QueryController
{
    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 10;

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $offset = $request->query->getInt('offset', self::DEFAULT_OFFSET);
            $limit = $request->query->getInt('limit', self::DEFAULT_LIMIT);

            $query = FindAllEventsQuery::create($offset, $limit);
            $resources = $this->queryBus->handle($query);

            return Response::OK($resources, "Eventos encontrados");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            dd($e);
            return Response::SERVER_ERROR();
        }
    }
}
