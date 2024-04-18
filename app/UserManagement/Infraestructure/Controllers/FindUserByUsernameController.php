<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\FindByUsername\FindByUsernameQuery;
use Exception;
use Illuminate\Http\JsonResponse;

class FindUserByUsernameController extends Controller
{
    public function __construct(private readonly QueryBus  $queryBus)
    {}

    public function __invoke(string $id): JsonResponse
    {
        $query = new FindByUsernameQuery($id);
        try {
            $result = $this->queryBus->handle($query);
            return new JsonResponse($result);

        } catch (NotFoundException $exception) {
            return Response::NO_CONTENT($exception->getMessage());

        } catch (Exception $exception) {
            dd($exception);
        }
    }
}
