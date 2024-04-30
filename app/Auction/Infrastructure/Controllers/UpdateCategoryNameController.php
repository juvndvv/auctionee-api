<?php

namespace App\Auction\Infrastructure\Controllers;

use App\Auction\Application\Command\UpdateCategoryName\UpdateCategoryNameCommand;
use App\Shared\Infrastructure\Controllers\Response;
use App\Shared\Infrastructure\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\Request;

final class UpdateCategoryNameController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request)
    {
        try {
            self::validate($request);

            $name = $request->input("name");

            $command = UpdateCategoryNameCommand::create($uuid, $name);
            $this->commandBus->handle($command);

            return Response::OK($name, "Nombre de la categoria actualizado");


        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate([
            'name' => 'required|string'
        ]);
    }
}
