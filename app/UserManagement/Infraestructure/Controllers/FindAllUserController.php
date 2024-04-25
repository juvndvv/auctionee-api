<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\FindAll\FindAllUserQuery;
use Illuminate\Http\JsonResponse;

class FindAllUserController extends Controller
{
    public function __construct(private readonly QueryBus $queryBus)
    {}

    public function __invoke(): JsonResponse
    {
        $query = new FindAllUserQuery();

        try {
            $users = $this->queryBus->handle($query);
            return Response::OK($users, "Usuarios encontrados");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT($e->getMessage());

        } catch (\Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
