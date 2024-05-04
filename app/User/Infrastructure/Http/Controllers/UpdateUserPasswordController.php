<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use App\User\Application\Commands\UpdatePassword\UpdatePasswordCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateUserPasswordController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $password = $request["password"];

            $command = UpdatePasswordCommand::create($uuid, $password);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $password,
                message: "Contraseña actualizada"
            );

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND(
                message: $e->getMessage()
            );

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validación en la contraseña",
                error: $e->validator->getMessageBag()
            );

        } catch (Exception) {
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
