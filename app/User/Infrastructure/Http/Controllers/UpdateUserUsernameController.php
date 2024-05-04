<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use App\User\Application\Commands\UpdateUsername\UpdateUsernameCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateUserUsernameController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);
            $name = $request["username"];

            $command = UpdateUsernameCommand::create($uuid, $name);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $name,
                message: "Nombre actualizado correctamente"
            );

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validación en el nombre de usuario",
                error: $e->validator->getMessageBag()
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'username' => 'required|string|max:255',
        ]);
    }
}
