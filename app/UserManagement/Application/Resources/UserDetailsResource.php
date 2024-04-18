<?php

namespace Resources;


class UserDetailsResource
{
    public static function fromArray(array $data): array
    {
        return [
            "id" => $data['id'],
            "name" => $data['name'],
            "username" => $data['username'],
            "email" => $data['email'],
            "created_at" => $data['created_at'],
            "updated_at" => $data['updated_at']
        ];
    }
}
