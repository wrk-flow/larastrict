<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumberRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (is_string($value)) {
            $value = str_replace(',', '.', $value);
        }

        if ((is_float($value)) || (is_numeric($value) && str_contains((string) $value, '.'))) {
            $floatVal = (float) $value;
            $stringVal = (string) $floatVal;
            return is_finite($floatVal) && $stringVal === (string) $value;
        } elseif (is_numeric($value)) {
            $intVal = (int) $value;
            return $intVal !== PHP_INT_MAX && $intVal !== PHP_INT_MIN;
        }

        return false;
    }

    public function message(): string
    {
        return 'Given :attribute is not a valid number or it exceeds int/float limits.';
    }
}
