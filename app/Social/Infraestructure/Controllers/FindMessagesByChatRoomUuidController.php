<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Infraestructure\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\BaseController;
use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\FindMessagesByChatRoomUuid\FindMessagesByChatRoomUuidQuery;
use Illuminate\Http\Request;

final class FindMessagesByChatRoomUuidController extends QueryController
{
    public function __invoke(string $uuid)
    {
        $messages = $this->queryBus->handle(new FindMessagesByChatRoomUuidQuery($uuid));
        return Response::OK($messages, "Mensajes encontrados satisfactoriamente");
    }
}
