<?php

namespace App\Shared\Application\UploadImage;

use Illuminate\Http\UploadedFile;

class UploadImageCommand
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
