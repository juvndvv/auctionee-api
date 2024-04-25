<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\Queries\FindAll\FindAllUserQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindAllUserBaseController extends QueryController
{
    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 10;

    public function __invoke(Request $request): JsonResponse
    {
        $offset = $request->query->getInt('offset', self::DEFAULT_OFFSET);
        $limit = $request->query->getInt('limit', self::DEFAULT_LIMIT);

        $query = FindAllUserQuery::create($offset, $limit);

        try {
            $users = $this->queryBus->handle($query);
            return Response::OK($users, "Usuarios encontrados");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT($e->getMessage());

        } catch (\Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        // TODO: Implement validate() method.
    }
}
