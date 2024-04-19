<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\UpdateName\UpdateNameCommand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateUserNameController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke(string $uuid, Request $request)
    {
        try {
            self::validate($request);

            $name = $request["name"];

            $command = new UpdateNameCommand($uuid, $name);
            $this->commandBus->handle($command);

            return Response::OK($name, "Nombre actualizado correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en el nombre", $e->validator->getMessageBag());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    }
}
