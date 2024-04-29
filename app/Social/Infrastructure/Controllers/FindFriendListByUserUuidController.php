<?php

namespace App\Social\Infrastructure\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Controllers\QueryController;
use App\Shared\Infrastructure\Controllers\Response;
use App\Social\Application\Queries\FindFriendListByUserUuid\FindFriendListByUserUuidQuery;
use Exception;

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
