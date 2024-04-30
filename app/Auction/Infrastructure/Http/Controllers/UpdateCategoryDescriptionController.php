<?php declare(strict_types=1);

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\UpdateCategoryDescription\UpdateCategoryDescriptionCommand;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateCategoryDescriptionController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $description = $request->input("description");

            $command = UpdateCategoryDescriptionCommand::create($uuid, $description);
            $this->commandBus->handle($command);

            return Response::OK($description, "Nombre de la categoria actualizado");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validacion", $e->validator->getMessageBag());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate([
            'description' => 'required|string'
        ]);
    }
}
