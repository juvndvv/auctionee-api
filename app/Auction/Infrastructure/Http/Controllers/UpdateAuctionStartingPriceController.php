<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Commands\UpdateAuctionStartingPrice\UpdateAuctionStartingPriceCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Response;
use App\Shared\Infrastructure\Http\Controllers\ValidatedCommandController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class UpdateAuctionStartingPriceController extends ValidatedCommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            self::validate($request);

            $startingPrice = $request->input('starting_price');

            $command = UpdateAuctionStartingPriceCommand::create($uuid, $startingPrice);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $startingPrice,
                message: "Precio actualizado"
            );

        } catch (ValidationException $exception) {
            return Response::UNPROCESSABLE_ENTITY(
                message: "Errores de validacion",
                error: $exception->validator->getMessageBag()
            );

        } catch (NotFoundException $exception) {
            return Response::NOT_FOUND($exception->getMessage());

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }

    static function validate(Request $request): void
    {
        $request->validate(['starting_price' => 'required|numeric|decimal:2']);
    }
}
