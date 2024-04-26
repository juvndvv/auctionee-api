<?php

namespace App\Financial\Infrastructure\Controllers;

use App\Financial\Application\Query\FindTransactionsByWalletUuid\FindTransactionsByWalletUuidQuery;
use App\Shared\Infrastucture\Bus\QueryBus;
use App\Shared\Infrastucture\Controllers\BaseController;
use App\Shared\Infrastucture\Controllers\Response;
use Exception;

class FindTransactionsByWalletUuidBaseController extends BaseController
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
