<?php

namespace App\Shared\Application\UploadImage;

use App\Shared\Application\Command;
use Illuminate\Http\UploadedFile;

class UploadImageCommand extends Command
{
    private function __construct(
        private readonly string $folder,
        private readonly UploadedFile $uploadedFile
    )
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
