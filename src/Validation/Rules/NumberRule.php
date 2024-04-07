<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use LaraStrict\Core\Helpers\Value;

final class NumberRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (self::passes($value) === false) {
            $fail('Given :attribute is not a valid number or it exceeds int/float limits.');
        }
    }

    private static function passes(mixed $value): bool
    {
        if (is_string($value) === false && is_numeric($value) === false) {
            return false;
        }

        if (self::isNumericInt($value)) {
            $intVal = (int) $value;
            return $intVal !== PHP_INT_MAX && $intVal !== PHP_INT_MIN;
        }

        $value = Value::toFloat((string) $value);

        if ($value === null) {
            return false;
        }

        return str_contains((string) $value, 'E+') === false;
    }

    /**
     * @return ($value is non-empty-string ? bool : ($value is int ? true : false))
     */
    private static function isNumericInt(mixed $value): bool
    {
        return is_int($value) || (is_string($value) && preg_match('#^[+-]?\d+$#D', $value));
    }
}
