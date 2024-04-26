<?php

namespace App\User\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;
use App\User\Application\Queries\FindByUsername\FindByUsernameQuery;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindUserByUsernameController extends QueryController
{
    public function __invoke(string $id): JsonResponse
    {
        try {
            $query = FindByUsernameQuery::create($id);
            $result = $this->queryBus->handle($query);

            return new JsonResponse($result);

        } catch (NotFoundException $e) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
