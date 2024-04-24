<?php

namespace App\Financial\Infraestructure\Controllers;

use App\Financial\Application\FindTransactionsByWalletUuid\FindTransactionsByWalletUuidQuery;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infraestructure\Controllers\Controller;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;

class FindTransactionsByWalletUuidController extends Controller
{
    public function __construct(
        private readonly QueryBus $queryBus
    )
    {}

    public function __invoke(string $uuid)
    {
        try {
            $query = new FindTransactionsByWalletUuidQuery($uuid);
            $resources = $this->queryBus->handle($query);
            return Response::OK($resources, "Transacciones encontradas");

        } catch (Exception $e) {
            dd($e);
            return Response::SERVER_ERROR();
        }
    }
}
