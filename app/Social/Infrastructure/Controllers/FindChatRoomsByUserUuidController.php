<?php

namespace App\Social\Infrastructure\Controllers;

use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastucture\Controllers\QueryController;
use App\Shared\Infrastucture\Controllers\Response;
use App\Social\Application\Queries\FindChatRoomsByUserUuid\FindChatRoomsByUserUuidQuery;
use Exception;
use Illuminate\Http\Request;

final class FindChatRoomsByUserUuidController extends QueryController
{
    public function __invoke(string $userUuid)
    {
        try {
            self::validate(new Request());

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
