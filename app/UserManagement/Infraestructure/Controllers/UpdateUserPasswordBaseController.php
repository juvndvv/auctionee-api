<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Infraestructure\Controllers\CommandController;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\Commands\UpdatePassword\UpdatePasswordCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateUserPasswordBaseController extends CommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $password = $request["password"];

            $command = UpdatePasswordCommand::create($uuid, $password);
            $this->commandBus->handle($command);

            return Response::OK($password, "Contraseña actualizada correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en la contraseña", $e->validator->getMessageBag());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'password' => 'required|string|max:255',
        ]);
    }
}