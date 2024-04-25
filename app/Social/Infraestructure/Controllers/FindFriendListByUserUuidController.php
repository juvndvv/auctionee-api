<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\BaseController;
use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\FindFriendListByUserUuid\FindFriendListByUserUuidQuery;
use Exception;
use Illuminate\Http\Request;

final class FindFriendListByUserUuidController extends QueryController
{
    public function __invoke(string $userUuid)
    {
        try {
            $query = FindFriendListByUserUuidQuery::create($userUuid);
            $resources = $this->queryBus->handle($query);

            return Response::OK($resources, "Amigos encontrados");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
