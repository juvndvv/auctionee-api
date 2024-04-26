<?php

namespace App\User\Domain\Resources;

final class UserDetailsResource
{
    public static function fromArray(array $data): array
    {
        return [
            "uuid" => $data['uuid'],
            "name" => $data['name'],
            "username" => $data['username'],
            "email" => $data['email'],
            "avatar" => env("CLOUDFLARE_R2_URL") . $data['avatar'],
            "birth" => $data['birth'],
            "role" => match ($data["role"]) {
                1 => "ADMIN",
                2 => "BLOCKED",
                3 => "DELETED",
                default =>  "USER"
            },
            "created_at" => $data['created_at'],
            "updated_at" => $data['updated_at']
        ];
    }
}
