<?php

namespace App\Social\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use App\Social\Application\Commands\SendMessage\SendMessageCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class SendMessageController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $senderUuid = $request->user()->uuid;
            $content = $request->input('content');

            $command = SendMessageCommand::create($uuid, $senderUuid, $content);
            $messageUuid = $this->commandBus->handle($command);

            return Response::OK(
                data: $messageUuid,
                message: "Mensaje enviado"
            );

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validación",
                error: $e->validator->getMessageBag()
            );

        } catch (Exception $e) {
            return Response::SERVER_ERROR($e->getMessage());
        }
    }

    static function validate(Request $request): void
    {
        $request->validate(['content' => 'required']);
    }
}
