<?php

namespace App\Shared\Infrastructure\Controllers;

use Illuminate\Http\Request;

abstract class ValidatedCommandController extends CommandController
{
    abstract static function validate(Request $request): void;
}
