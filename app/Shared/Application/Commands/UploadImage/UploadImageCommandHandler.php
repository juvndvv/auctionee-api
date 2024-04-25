<?php

namespace App\Shared\Application\Commands\UploadImage;

use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infraestructure\Bus\Command\CommandHandler;

class UploadImageCommandHandler extends CommandHandler
{
    public function __construct(private readonly ImageRepositoryPort $imageRepository)
    {}

    public function __invoke(UploadImageCommand $command): string
    {
        $folder = $command->folder();
        $file = $command->uploadedFile();

        return $this->imageRepository->store($folder, $file);
    }
}
