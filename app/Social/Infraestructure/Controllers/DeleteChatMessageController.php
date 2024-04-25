<?php

namespace App\Social\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use App\Social\Application\DeleteMessage\DeleteMessageCommand;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteChatMessageController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke(string $chatUuid, string $messageUuid): JsonResponse
    {
        try {
            $command = new DeleteMessageCommand($chatUuid, $messageUuid);
            $this->commandBus->handle($command);

            return Response::OK("", "Mensaje eliminado correctamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
