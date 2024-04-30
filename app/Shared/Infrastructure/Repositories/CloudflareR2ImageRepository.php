<?php

namespace App\Shared\Infrastructure\Repositories;

use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class CloudflareR2ImageRepository implements ImageRepositoryPort
{

    public function store(string $folder, UploadedFile $file): string
    {
        return "/" . $file->store($folder, 'r2');
    }

    public function storeAll(string $folder, array $files): array
    {
        $paths = [];
        foreach ($files as $file) {
            $paths[] = $this->store($folder, $file);
        }
        return $paths;
    }

    public function delete(string $path): void
    {
        Storage::disk("r2")->delete($path);
    }

    public function exists(string $path): bool
    {
        return Storage::disk("r2")->exists($path);
    }
}
