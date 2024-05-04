<?php

namespace App\User\Infrastructure\Http\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use App\User\Application\Commands\UpdateEmail\UpdateEmailCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateUserEmailController extends ValidatedCommandController
{
    public function __invoke($uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $email = $request['email'];

            $command = UpdateEmailCommand::create($uuid, $email);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $email,
                message: "Email actualizado"
            );

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validación en el nombre",
                error: $e->validator->getMessageBag()
            );

        }  catch (NotFoundException $e) {
            return Response::NOT_FOUND(
                message: $e->getMessage()
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            "email" => "required|email",
        ]);
    }
}
