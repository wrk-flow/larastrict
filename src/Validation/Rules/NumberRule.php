<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumberRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (is_float($value)) {
            return $value <= PHP_FLOAT_MAX && $value >= PHP_FLOAT_MIN;
        } elseif (is_numeric($value)) {
            return $value <= PHP_INT_MAX && $value >= PHP_INT_MIN;
        }

        return false;
    }

    public function message(): string
    {
        return 'Given :attribute is not a valid number or it exceeds int/float limits.';
    }
}
