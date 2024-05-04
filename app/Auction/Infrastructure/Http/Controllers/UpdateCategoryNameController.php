<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\UpdateCategoryName\UpdateCategoryNameCommand;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UpdateCategoryNameController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $name = $request->input("name");

            $command = UpdateCategoryNameCommand::create($uuid, $name);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $name,
                message: "Nombre de la categoria actualizado"
            );


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
