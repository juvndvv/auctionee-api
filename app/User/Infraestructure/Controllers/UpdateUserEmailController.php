<?php

namespace App\User\Infraestructure\Controllers;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\Response;
use App\Shared\Infraestructure\Controllers\ValidatedCommandController;
use App\User\Application\Commands\UpdateEmail\UpdateEmailCommand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateUserEmailController extends ValidatedCommandController
{
    public function __invoke($uuid, Request $request)
    {
        try {
            self::validate($request);

            $email = $request['email'];

            $command = UpdateEmailCommand::create($uuid, $email);
            $this->commandBus->handle($command);

            return Response::OK($email, "Email actualizado correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el nombre", $e->validator->getMessageBag());

        }  catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
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
