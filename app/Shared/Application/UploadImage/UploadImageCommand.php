<?php

namespace App\Shared\Application\UploadImage;

use App\Shared\Domain\Bus\Command\Command;
use Illuminate\Http\UploadedFile;

class UploadImageCommand extends Command
{
    public function __construct(private readonly string $folder, private readonly UploadedFile $uploadedFile)
    {}

    public function folder(): string
    {
        return $this->folder;
    }

     public function uploadedFile(): UploadedFile
     {
         return $this->uploadedFile;
     }
}
