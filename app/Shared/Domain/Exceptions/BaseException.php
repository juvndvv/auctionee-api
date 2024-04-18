<?php

namespace App\Shared\Domain\Exceptions;

use Throwable;

abstract class BaseException extends \Exception
{
    public string $value;
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, string $value = "")
    {
        parent::__construct($message, $code, $previous);
    }
}
