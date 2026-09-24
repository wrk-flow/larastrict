<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rule that is usable in Laravel (validate method) or in your business logic (passes method).
 */
final class BooleanRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (self::passes($value) === false) {
            $fail('Given :attribute is not a valid boolean: true, false, 0, 1 (can be string or numeric value).');
        }
    }

    public static function passes(mixed $value): bool
    {
        return in_array($value, [true, false, 'true', 'false', 0, 1, '0', '1'], true);
    }
}
