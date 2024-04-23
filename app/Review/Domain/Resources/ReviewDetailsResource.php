<?php

namespace App\Review\Domain\Resources;

class ReviewDetailsResource
{
    public static function toArray(array $data)
    {
        return [
            'reviewer_username' => $data['reviewer_username'],
            'reviewer_avatar' => $data['reviewer_avatar'],
            'rating' => $data['rating'],
            'description' => $data['description'],
            'created_at' => $data['created_at'],
        ];
    }
}
