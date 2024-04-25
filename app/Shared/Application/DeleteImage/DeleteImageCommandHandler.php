<?php

namespace App\Shared\Application\DeleteImage;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infraestructure\Bus\Command\CommandHandler;

class DeleteImageCommandHandler extends CommandHandler
{
    public function __construct(private readonly ImageRepositoryPort  $imageRepository)
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(DeleteImageCommand $command): void
    {
        $path = $command->path();

        if (!$this->imageRepository->exists($path)) {
            throw new NotFoundException("La imagen " . $path . " no existe");
        }

        $this->imageRepository->delete($path);

    }
}
