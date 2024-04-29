<?php

namespace App\User\Infrastructure\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastucture\Controllers\QueryController;
use App\Shared\Infrastucture\Controllers\Response;
use App\User\Application\Queries\FindByUuid\FindByUuidQuery;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindUserByUuidController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
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
}
