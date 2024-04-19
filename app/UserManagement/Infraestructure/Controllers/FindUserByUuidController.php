<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\FindByUuid\FindByUuidQuery;
use Exception;

class FindUserByUuidController extends Controller
{
    public function __construct(private readonly QueryBus $queryBus)
    {}

    public function __invoke(string $uuid)
    {
        try {
            $query = new FindByUuidQuery($uuid);
            $resource = $this->queryBus->handle($query);

            return Response::OK($resource, "Usuario encontrado satisfactoriamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
