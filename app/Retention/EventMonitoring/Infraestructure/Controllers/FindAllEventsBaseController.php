<?php

namespace App\Retention\EventMonitoring\Infraestructure\Controllers;

use App\Retention\EventMonitoring\Application\FindAll\FindAllEventsQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\BaseController;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;
use Illuminate\Http\Request;

class FindAllEventsBaseController extends BaseController
{
    public function __construct(private readonly QueryBus $queryBus)
    {}

    public function __invoke(Request $request)
    {
        try {
            $query = new FindAllEventsQuery();
            $resources = $this->queryBus->handle($query);

            return Response::OK($resources, "Eventos encontrados");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
