<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\FindMessagesByChatRoomUuid\FindMessagesByChatRoomUuidQuery;

final class FindMessagesByChatRoomUuidController extends QueryController
{
    public function __invoke(string $uuid)
    {
        $messages = $this->queryBus->handle(new FindMessagesByChatRoomUuidQuery($uuid));
        return Response::OK($messages, "Mensajes encontrados satisfactoriamente");
    }
}
