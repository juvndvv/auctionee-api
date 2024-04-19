<?php

namespace App\UserManagement\Application\Resources;

class UserSmallResource
{
    public static function fromArray(array $data): array
    {
        return [
            "name" => $data["name"],
            "username" => $data["username"],
            "email" => $data["email"],
            "avatar" => env("CLOUDFLARE_R2_URL") . $data["avatar"],
        ];
    }
}
