<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use LaraStrict\Core\Helpers\Value;

class NumberRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (is_string($value)) {
            $value = preg_replace('#\s+#', '', $value);
        }

        if (self::isNumericInt($value)) {
            $intVal = (int) $value;
            return $intVal !== PHP_INT_MAX && $intVal !== PHP_INT_MIN;
        } elseif (is_scalar($value) === false) {
            return false;
        }

        $value = Value::toFloat((string) $value);

        return $value !== null && (str_contains((string) $value, 'E+') === false);
    }

    public function message(): string
    {
        return 'Given :attribute is not a valid number or it exceeds int/float limits.';
    }

    /**
     * @return ($value is non-empty-string ? bool : ($value is int ? true : false))
     */
    private static function isNumericInt(mixed $value): bool
    {
        return is_int($value) || (is_string($value) && preg_match('#^[+-]?\d+$#D', $value));
    }
}
