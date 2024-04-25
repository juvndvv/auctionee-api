<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\Queries\FindByUuid\FindByUuidQuery;
use Exception;
use Illuminate\Http\Request;

final class FindUserByUuidBaseController extends QueryController
{
    public function __invoke(string $uuid)
    {
        try {
            $query = FindByUuidQuery::create($uuid);
            $resource = $this->queryBus->handle($query);

            return Response::OK($resource, "Usuario encontrado satisfactoriamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        // TODO: Implement validate() method.
    }
}
