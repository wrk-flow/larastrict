<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rule that is usable in Laravel (validate method) or in your business logic (passes method).
 */
final class ArrayOrStringRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (self::passes($value) === false) {
            $fail('Given :attribute must by array or string');
        }
    }

    public static function passes(mixed $value): bool
    {
        return is_array($value) || is_string($value);
    }
}
