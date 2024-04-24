<?php

namespace App\Financial\Infraestructure\Controllers;

use App\Financial\Application\DepositMoney\DepositMoneyCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;
use Illuminate\Http\Request;

class DepositMoneyController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke(string $uuid, Request $request)
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
