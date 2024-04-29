<?php

namespace App\Financial\Infrastructure\Controllers;

use App\Financial\Application\Command\DepositMoney\DepositMoneyCommand;
use App\Shared\Infrastructure\Controllers\CommandController;
use App\Shared\Infrastructure\Controllers\Response;
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

            return Response::OK(null, "El dinero se ha ingresado correctamente");

        } catch (Exception) {
            return Response::SERVER_ERROR();
        }
    }
}
