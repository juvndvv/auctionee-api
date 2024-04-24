<?php

namespace App\Financial\Infraestructure\Controllers;

use App\Financial\Application\MakeTransaction\MakeTransactionCommand;
use App\Financial\Domain\Exeptions\NotEnoughFoundsException;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;
use Illuminate\Http\Request;

class MakeTransactionController extends Controller
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
