<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infraestructure\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\BaseController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\FindChatRoomsByUserUuid\FindChatRoomsByUserUuidQuery;
use Exception;

class FindChatRoomsByUserUuidBaseController extends BaseController
{
    public function __construct(
        private readonly QueryBus $queryBus
    )
    {}

    public function __invoke(string $userUuid)
    {
        try {
            $query = new FindChatRoomsByUserUuidQuery($userUuid);
            $resources = $this->queryBus->handle($query);

            return Response::OK($resources, "Chats encontrados");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
