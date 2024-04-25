<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Infraestructure\Controllers\CommandController;
use App\Shared\Infraestructure\Controllers\Response;
use App\Shared\Infraestructure\Controllers\ValidatedCommandController;
use App\UserManagement\Application\Commands\UpdateName\UpdateNameCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateUserUsernameBaseController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);
            $name = $request["username"];

            $command = UpdateNameCommand::create($uuid, $name);
            $this->commandBus->handle($command);

            return Response::OK($name, "Nombre actualizado correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el nombre de usuario", $e->validator->getMessageBag());

        } catch (Exception $e) {
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
