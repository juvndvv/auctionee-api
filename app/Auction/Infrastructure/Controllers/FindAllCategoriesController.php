<?php

namespace App\Auction\Infrastructure\Controllers;

use App\Auction\Application\Queries\FindAllCategories\FindAllCategoriesQuery;
use App\Shared\Domain\Exceptions\NoContentException;
use App\Shared\Infrastructure\Controllers\QueryController;
use App\Shared\Infrastructure\Controllers\Response;
use Exception;

final class FindAllCategoriesController extends QueryController
{
    public function __invoke()
    {
        try {
            $query = new FindAllCategoriesQuery();
            $resources = $this->queryBus->handle($query);

            return Response::OK($resources, "Categorias encontradas");

        } catch (NoContentException $e) {
            return Response::NO_CONTENT();

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
