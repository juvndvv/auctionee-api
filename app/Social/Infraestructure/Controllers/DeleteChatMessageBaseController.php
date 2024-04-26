<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\CommandController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\DeleteMessage\DeleteMessageCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DeleteChatMessageBaseController extends CommandController
{
    public function __invoke(string $chatUuid, string $messageUuid): JsonResponse
    {
        try {
            self::validate(new Request());

            $command = new DeleteMessageCommand($chatUuid, $messageUuid);
            $this->commandBus->handle($command);

            return Response::OK("", "Mensaje eliminado correctamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        // TODO: Implement validate() method.
    }
}
