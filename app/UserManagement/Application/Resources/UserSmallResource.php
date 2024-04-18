<?php

namespace Resources;

class UserSmallResource
{
    public static function fromArray(array $data)
    {
        return [
            "name" => $data["name"],
            "username" => $data["username"],
            "email" => $data["email"]
        ];
    }
}
