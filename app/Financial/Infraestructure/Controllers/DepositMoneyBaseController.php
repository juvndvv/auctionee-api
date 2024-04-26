<?php

namespace App\Financial\Infraestructure\Controllers;

use App\Financial\Application\Command\DepositMoney\DepositMoneyCommand;
use App\Shared\Infraestructure\Controllers\CommandController;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DepositMoneyBaseController extends CommandController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $amount = $request['amount'];

            $command = new DepositMoneyCommand($uuid, $amount);
            $this->commandBus->handle($command);

            return Response::OK(null, "El dinero se ha ingresado correctamente");

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
