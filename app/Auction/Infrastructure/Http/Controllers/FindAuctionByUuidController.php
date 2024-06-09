<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Queries\FindAuctionByUuid\FindAuctionByUuidQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;

final class FindAuctionByUuidController extends QueryController
{
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $query = FindAuctionByUuidQuery::create($uuid);
            $resources = $this->queryBus->handle($query);
            return Response::OK(
                data: $resources,
                message: "Subasta encontrada"
            );

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            dd($e);
            return Response::SERVER_ERROR($e->getMessage());
        }
    }
}
