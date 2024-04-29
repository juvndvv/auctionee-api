<?php

namespace App\Shared\Application\Commands\UploadImage;

use App\Shared\Application\Commands\Command;
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

     public static function create(string $folder, UploadedFile $uploadedFile): self
     {
         return new self($folder, $uploadedFile);
     }
}
