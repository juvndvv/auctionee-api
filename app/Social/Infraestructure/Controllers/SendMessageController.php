<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Infraestructure\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\BaseController;
use App\Shared\Infraestructure\Controllers\QueryController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\SendMessage\SendMessageCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SendMessageController extends QueryController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $senderUuid = $request->input('sender_uuid');
            $content = $request->input('content');

            $command = new SendMessageCommand($uuid, $senderUuid, $content);
            $this->queryBus->handle($command);

            return Response::OK(null, "Mensaje enviado");


        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
