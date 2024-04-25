<?php

namespace App\Shared\Application;

trait Creatable
{
    public static function create(...$args): static
    {
        return static(...$args);
    }
}
