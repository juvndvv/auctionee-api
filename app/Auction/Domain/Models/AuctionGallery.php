<?php

namespace App\Auction\Domain\Models;

use App\Shared\Domain\Models\ValueObjects\ImageUrl;

class AuctionGallery
{
    public array $images;

    public function __construct(array $imagesStr)
    {
        $this->images = array_map(function ($imageUrl) { return new ImageUrl($imageUrl);}, $imagesStr);
    }

    public function addImage(ImageUrl $imageUrl): void
    {
        $this->images[] = $imageUrl;
    }

    public function removeImageByPosition(int $position): void
    {
        unset($this->images[$position]);
        $this->images = array_values($this->images);
    }
}
