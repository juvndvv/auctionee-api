<?php

namespace App\Review\Domain\Models\ValueObjects;

use App\Shared\Domain\Models\ValueObjects\IntValueObject;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

class ReviewRating extends IntValueObject
{
    public function __construct(protected int $value)
    {
        parent::__construct($value);
    }

    public static function ensureIsValid(int $value): void
    {
        if ($value < 0 || $value > 5) {
            throw new InvalidArgumentException("El valor debe estar entre 0 y 5");
        }
    }
}
