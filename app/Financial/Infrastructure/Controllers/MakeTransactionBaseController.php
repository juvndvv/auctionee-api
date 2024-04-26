<?php

namespace App\Financial\Infrastructure\Controllers;

use App\Financial\Application\Command\MakeTransaction\MakeTransactionCommand;
use App\Financial\Domain\Exeptions\NotEnoughFoundsException;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastucture\Bus\CommandBus;
use App\Shared\Infrastucture\Controllers\BaseController;
use App\Shared\Infrastucture\Controllers\Response;
use Exception;
use Illuminate\Http\Request;

class MakeTransactionBaseController extends BaseController
{
    public function __construct(
        private readonly CommandBus $commandBus
    )
    {}

    public function __invoke(string $uuid, Request $request)
    {
        try {
            $destinationWallet = $request['destination_wallet'];
            $amount = $request['amount'];

            $command = new MakeTransactionCommand($uuid, $destinationWallet, $amount);
            $this->commandBus->handle($command);

            return Response::OK(null, "Transacción realizada");

        } catch (NotFoundException $e) {
            return Response::BAD_REQUEST($e->getMessage());

        } catch (NotEnoughFoundsException $e) {
            return Response::BAD_REQUEST($e->getMessage());

        } catch (Exception $e) {
            dd($e->getMessage());
            return Response::SERVER_ERROR();
        }
    }
}
