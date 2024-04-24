<?php

namespace App\UserManagement\Application\Resources;

class UserSmallResource
{
    public static function fromArray(array $data): array
    {
        if ($data['role'] === 3) {
            return [
                "name" => "Usuario eliminado",
                "username" => "deletedUser",
                "avatar" => env("CLOUDFLARE_R2_URL") . env("DEFAULT_AVATAR"),
            ];
        }

        return [
            "name" => $data["name"],
            "username" => $data["username"],
            "avatar" => env("CLOUDFLARE_R2_URL") . $data["avatar"],
        ];
    }
}
