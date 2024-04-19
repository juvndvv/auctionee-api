<?php

namespace App\UserManagement\Application\Resources;

class UserDetailsResource
{
    public static function fromArray(array $data): array
    {
        return [
            "uuid" => $data['uuid'],
            "name" => $data['name'],
            "username" => $data['username'],
            "email" => $data['email'],
            "avatar" => env("CLOUDFLARE_R2_URL") . $data['avatar'],
            "created_at" => $data['created_at'],
            "updated_at" => $data['updated_at']
        ];
    }
}
