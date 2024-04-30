<?php

namespace App\Social\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Social\Application\Queries\FindChatRoomsByUserUuid\FindChatRoomsByUserUuidQuery;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindChatRoomsByUserUuidController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $query = FindChatRoomsByUserUuidQuery::create($uuid);
            $resources = $this->queryBus->handle($query);

            return Response::OK($resources, "Chats encontrados");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
