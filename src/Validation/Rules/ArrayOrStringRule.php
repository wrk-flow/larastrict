<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class ArrayOrStringRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (self::passes($value) === false) {
            $fail('Given :attribute must by array or string');
        }
    }

    private function passes(mixed $value): bool
    {
        return is_array($value) || is_string($value);
    }
}
