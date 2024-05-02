<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\UpdateAuctionName\UpdateAuctionNameCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateAuctionNameController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $name = $request->input('name');

            $command = UpdateAuctionNameCommand::create($uuid, $name);
            $this->commandBus->handle($command);

            return Response::OK(null, "Nombre actualizado");

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY("Errores de validacion", $exception->validator->getMessageBag());

        } catch (NotFoundException $exception) {
            return Response::NOT_FOUND($exception->getMessage());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate(['name' => 'required|string']);
    }
}
