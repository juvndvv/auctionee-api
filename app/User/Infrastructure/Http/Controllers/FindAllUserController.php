<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\User\Application\Queries\FindAll\FindAllUserQuery;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindAllUserController extends QueryController
{
    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 20;

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $offset = $request->query->getInt('offset', self::DEFAULT_OFFSET);
            $limit = $request->query->getInt('limit', self::DEFAULT_LIMIT);

            $query = FindAllUserQuery::create($offset, $limit);

            $users = $this->queryBus->handle($query);
            return Response::OK($users, "Usuarios encontrados");

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
