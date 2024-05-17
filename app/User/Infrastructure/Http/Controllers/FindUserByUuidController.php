<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Application\Queries\FindByUuid\FindByUuidQuery;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindUserByUuidController extends QueryController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $query = FindByUuidQuery::create($uuid);
            $resource = $this->queryBus->handle($query);

            $fullUser = $request->query('full');

            if ($fullUser) {

            }

            return Response::OK(
                data: $resource,
                message: "Usuario encontrado"
            );

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND(
                message: $e->getMessage()
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
