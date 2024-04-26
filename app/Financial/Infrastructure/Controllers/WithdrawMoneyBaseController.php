<?php

namespace App\Financial\Infrastructure\Controllers;

use App\Financial\Application\Query\WithdrawMoney\WithdrawMoneyCommand;
use App\Financial\Domain\Exeptions\NotEnoughFoundsException;
use App\Shared\Infrastucture\Bus\CommandBus;
use App\Shared\Infrastucture\Controllers\BaseController;
use App\Shared\Infrastucture\Controllers\Response;
use Exception;
use Illuminate\Http\Request;

class WithdrawMoneyBaseController extends BaseController
{
    public function __construct(
        private readonly CommandBus $commandBus
    )
    {}

    public function __invoke(string $uuid, Request $request)
    {
        try {
            $amount = $request['amount'];

            $command = new WithdrawMoneyCommand($uuid, $amount);
            $this->commandBus->handle($command);

            return Response::OK(null, "Dinero retirado correctamente");

        } catch (NotEnoughFoundsException $e) {
            return Response::BAD_REQUEST($e->getMessage());

        } catch (Exception $d) {
            return Response::SERVER_ERROR();
        }
    }
}
