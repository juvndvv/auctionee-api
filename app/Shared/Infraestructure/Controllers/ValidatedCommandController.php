<?php

namespace App\Shared\Infraestructure\Controllers;

use Illuminate\Http\Request;

abstract class ValidatedCommandController extends CommandController
{
    abstract static function validate(Request $request): void;
}
