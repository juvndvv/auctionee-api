<?php

namespace App\Review\Infrastructure\Controllers;

use App\Review\Application\Command\RemoveReview\RemoveReviewCommand;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Infrastucture\Controllers\CommandController;
use App\Shared\Infrastucture\Controllers\Response;
use Exception;

final class RemoveReviewController extends CommandController
{
    public function __invoke(string $uuid)
    {
        try {
            $this->commandBus->handle(RemoveReviewCommand::create($uuid));
            return Response::OK($uuid, "Review eliminada satisfactoriamente");

        } catch (NotFoundException $e) {
            return Response::NOT_FOUND($e->getMessage());

        } catch (Exception $e) {
            return Response::SERVER_ERROR();
        }
    }
}
