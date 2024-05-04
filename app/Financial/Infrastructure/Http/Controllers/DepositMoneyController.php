<?php

namespace App\Financial\Infrastructure\Http\Controllers;

use App\Financial\Application\Command\DepositMoney\DepositMoneyCommand;
use App\Shared\Infrastructure\Http\Controllers\CommandController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DepositMoneyController extends CommandController
{

    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $amount = $request['amount'];

            $command = new DepositMoneyCommand($uuid, $amount);
            $this->commandBus->handle($command);

            return Response::OK(
                data: $amount,
                message: "El dinero se ha ingresado"
            );

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
