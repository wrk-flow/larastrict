<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class BooleanRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (self::passes($value) === false) {
            $fail('Given :attribute is not a valid boolean: true, false, 0, 1 (can be string or numeric value).');
        }
    }

    private function passes(mixed $value): bool
    {
        if (is_array($value) === false) {
            return false;
        }

        return in_array($value, [true, false, 'true', 'false', 0, 1, '0', '1'], true);
    }
}
