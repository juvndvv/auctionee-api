<?php

namespace App\Social\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\BadRequestException;
use App\Shared\Infrastructure\Http\Controllers\CommandController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Social\Application\Commands\CreateChatRoom\CreateChatRoomCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class CreateChatRoomController extends CommandController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $leftUuid = $request->user()->uuid;
            $rightUuid = $request->input("user_uuid");

            $command = CreateChatRoomCommand::create($leftUuid, $rightUuid);
            $uuid = $this->commandBus->handle($command);

            return Response::CREATED(
                message: "Sala creada correctamente",
                url: "/chatrooms/" . $uuid
            );

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Hubieron errores de validación",
                error: $e->validator->getMessageBag()
            );

        } catch (BadRequestException $e) {
            return Response::BAD_REQUEST(
                message: $e->getMessage()
            );

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate([
            "user_uuid" => "required"
        ]);
    }
}
