<?php

namespace App\Shared\Application\UploadImage;

use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;

class UploadImageCommandHandler
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
