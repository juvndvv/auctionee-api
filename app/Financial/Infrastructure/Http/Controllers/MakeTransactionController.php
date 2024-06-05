<?php

namespace App\Financial\Infrastructure\Http\Controllers;

use App\Financial\Application\Command\MakeTransaction\MakeTransactionCommand;
use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastructure\Http\Controllers\CommandController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class MakeTransactionController extends CommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $destinationWallet = $request['destination_wallet'];
            $amount = $request['amount'];

            $command = new MakeTransactionCommand($uuid, $destinationWallet, $amount);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $uuid,
                message: "Transacción realizada"
            );

        } catch (NotFoundException|NotEnoughFoundsException $exception) {
            return Response::BAD_REQUEST(
                message: $exception->getMessage()
            );

        } catch (Exception $exception) {
            return $exception->getMessage();
            return Response::SERVER_ERROR();
        }
    }
}
