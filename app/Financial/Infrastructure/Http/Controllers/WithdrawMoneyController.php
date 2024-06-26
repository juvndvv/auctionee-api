<?php

namespace App\Financial\Infrastructure\Http\Controllers;

use App\Financial\Application\Command\WithdrawMoney\WithdrawMoneyCommand;
use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Shared\Infrastructure\Http\Controllers\CommandController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class WithdrawMoneyController extends CommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $amount = $request['amount'];

            $command = new WithdrawMoneyCommand($uuid, $amount);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $uuid,
                message: "Dinero retirado"
            );

        } catch (NotEnoughFoundsException $exception) {
            return Response::BAD_REQUEST(
                message: $exception->getMessage()
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
