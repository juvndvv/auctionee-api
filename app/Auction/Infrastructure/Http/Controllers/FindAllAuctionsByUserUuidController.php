<?php

namespace App\Auction\Infrastructure\Http\Controllers;

use App\Auction\Application\Queries\FindAllAuctionByUserUuid\FindAllAuctionsByUserUuidQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Http\Controllers\QueryController;
use App\Shared\Infrastructure\Http\Controllers\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindAllAuctionsByUserUuidController extends QueryController
{
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        try {
            $query = FindAllAuctionsByUserUuidQuery::create($uuid);
            $resources = $this->queryBus->handle($query);

            return Response::OK(
                data: $resources,
                message: "Subastas encontradas"
            );

        } catch (NoContentException) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
