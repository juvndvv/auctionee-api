<?php

namespace App\Social\Infrastructure\Controllers;

use App\Shared\Domain\Exceptions\BadRequestException;
use App\Shared\Infrastructure\Controllers\CommandController;
use App\Shared\Infrastructure\Controllers\Response;
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

            $leftUuid = $request->input("left_uuid");
            $rightUuid = $request->input("right_uuid");

            $command = CreateChatRoomCommand::create($leftUuid, $rightUuid);
            $this->commandBus->handle($command);

            return Response::OK(null, "Sala creada correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Hubieron errores de validación", $e->validator->getMessageBag());

        } catch (BadRequestException $e) {
            return Response::BAD_REQUEST($e->getMessage());

        } catch (Exception $e) {
            dd($e->getMessage());
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate([
            "left_uuid" => "required",
            "right_uuid" => "required"
        ]);
    }
}
