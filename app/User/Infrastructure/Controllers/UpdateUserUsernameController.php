<?php

namespace App\User\Infrastructure\Controllers;

use App\Shared\Infrastucture\Controllers\Response;
use App\Shared\Infrastucture\Controllers\ValidatedCommandController;
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

            return Response::OK($name, "Nombre actualizado correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el nombre de usuario", $e->validator->getMessageBag());

        } catch (Exception $e) {
            dd($e->getMessage());
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
