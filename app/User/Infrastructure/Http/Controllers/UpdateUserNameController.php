<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use App\User\Application\Commands\UpdateName\UpdateNameCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateUserNameController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $name = $request["name"];

            $command = UpdateNameCommand::create($uuid, $name);
            $this->commandBus->handle($command);

            return Response::OK($name, "Nombre actualizado correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el nombre", $e->validator->getMessageBag());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    }
}
