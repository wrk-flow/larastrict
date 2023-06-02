<?php

declare(strict_types=1);

namespace LaraStrict\Core\Helpers;

final class Value
{
    public static function toFloat(string|int|float $value): ?float
    {
        if (is_string($value)) {
            $value = strtr($value, [
                ',' => '.',
            ]);

            if (is_numeric($value) === false) {
                return null;
            }
        }

        return (float) $value;
    }
}
