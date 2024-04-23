<?php

namespace App\Review\Infraestructure\Controllers;

use App\Review\Application\RemoveReview\RemoveReviewCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infraestructure\Controllers\Response;
use Exception;

class RemoveReviewController
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function __invoke(string $uuid)
    {
        try {
            $this->commandBus->handle(new RemoveReviewCommand($uuid));
            return Response::OK($uuid, "Review eliminada satisfactoriamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            dd($e);
            return Response::SERVER_ERROR();
        }
    }
}
