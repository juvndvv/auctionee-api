<?php

namespace App\Review\Infrastructure\Http\Controllers;

use App\Review\Application\Command\UpdateDescription\UpdateDescriptionCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateDescriptionController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $description = $request['description'];

            $command = UpdateDescriptionCommand::create($uuid, $description);
            $this->commandBus->handle($command);

            return Response::OK($description, "Descripcion actualizada correctamente");

        } catch (ValidationException $e) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validación en la descripcion", $e->validator->getMessageBag());

        }  catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'description' => 'required|string',
        ]);
    }
}
