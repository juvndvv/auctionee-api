<?php

namespace App\Social\Infrastructure\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Controllers\CommandController;
use App\Shared\Infrastructure\Controllers\Response;
use App\Social\Application\Commands\DeleteMessage\DeleteMessageCommand;
use Exception;
use Illuminate\Http\JsonResponse;

final class DeleteChatMessageController extends CommandController
{
    public function __invoke(string $chatUuid, string $messageUuid): JsonResponse
    {
        try {
            $command = DeleteMessageCommand::create($chatUuid, $messageUuid);
            $this->commandBus->handle($command);

            return Response::OK("", "Mensaje eliminado correctamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
