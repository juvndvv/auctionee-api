<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Application\Queries\FindByUsername\FindByUsernameQuery;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindUserByUsernameController extends QueryController
{
    public function __invoke(string $username): JsonResponse
    {
        try {
            $query = FindByUsernameQuery::create($username);
            $resource = $this->queryBus->handle($query);

            return Response::OK(
                data: $resource,
                message: "Usuario encontrado"
            );

        } catch (NotFoundException) {
            return Response::NOT_FOUND(
                message: "El usuario $username no existe"
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
