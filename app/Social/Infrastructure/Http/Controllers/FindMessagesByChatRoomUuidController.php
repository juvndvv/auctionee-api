<?php

namespace App\Social\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Social\Application\Queries\FindMessagesByChatRoomUuid\FindMessagesByChatRoomUuidQuery;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindMessagesByChatRoomUuidController extends QueryController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $token = $this->getTokenDateFromRequest($request);

            $query = FindMessagesByChatRoomUuidQuery::create($uuid, $token);
            $resource = $this->queryBus->handle($query);

            return Response::OK($resource, "Mensajes encontrados satisfactoriamente");

        } catch (NotFoundException $exception) {
            return Response::NOT_FOUND($exception->getMessage());

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception $exception) {
            return Response::SERVER_ERROR();
        }
    }

    public function getTokenDateFromRequest(Request $request): string
    {
        if ($request->hasHeader('Token')) {
            return base64_decode($request->header('Token'));
        }

        return "";
    }
}
