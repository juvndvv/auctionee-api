<?php

namespace App\Shared\Domain\Ports\Inbound;

use Illuminate\Http\UploadedFile;

interface ImageRepositoryPort
{
    public function store(string $folder, UploadedFile $file): string;
    public function storeAll(string $folder, array $files): array;
    public function delete(string $path): void;
    public function exists(string $path): bool;
}
