<?php

namespace App\UserManagement\Infraestructure\Controllers;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use App\UserManagement\Application\UpdateEmail\UpdateEmailCommand;
use Exception;
use Illuminate\Http\Request;

class UpdateUserEmailController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke($uuid, Request $request)
    {
        try {
            self::validate($request);

            $email = $request['email'];

            $command = new UpdateEmailCommand($uuid, $email);
            $this->commandBus->handle($command);

            return Response::OK("Email actualizado correctamente");

        }  catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request)
    {
        $request->validate([
            "email" => "required|email",
        ]);
    }
}
