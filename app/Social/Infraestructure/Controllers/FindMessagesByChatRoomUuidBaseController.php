<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Infraestructure\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\BaseController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\FindMessagesByChatRoomUuid\FindMessagesByChatRoomUuidQuery;

class FindMessagesByChatRoomUuidBaseController extends BaseController
{
    public function __construct(
        private readonly QueryBus $queryBus
    )
    {}

    public function __invoke(string $uuid)
    {
        $messages = $this->queryBus->handle(new FindMessagesByChatRoomUuidQuery($uuid));
        return Response::OK($messages, "Mensajes encontrados satisfactoriamente");
    }
}
