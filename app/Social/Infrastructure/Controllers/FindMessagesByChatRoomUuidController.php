<?php

namespace App\Social\Infrastructure\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Controllers\QueryController;
use App\Shared\Infrastructure\Controllers\Response;
use App\Social\Application\Queries\FindMessagesByChatRoomUuid\FindMessagesByChatRoomUuidQuery;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindMessagesByChatRoomUuidController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $query = FindMessagesByChatRoomUuidQuery::create($uuid);
            $messages = $this->queryBus->handle($query);

            return Response::OK($messages, "Mensajes encontrados satisfactoriamente");

        } catch (NotFoundException $exception) {
            return Response::NOT_FOUND($exception->getMessage());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
