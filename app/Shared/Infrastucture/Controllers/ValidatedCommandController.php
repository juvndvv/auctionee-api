<?php

namespace App\Shared\Infrastucture\Controllers;

use Illuminate\Http\Request;

abstract class ValidatedCommandController extends CommandController
{
    abstract static function validate(Request $request): void;
}
