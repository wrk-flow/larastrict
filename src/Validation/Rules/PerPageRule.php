<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class PerPageRule implements ValidationRule
{
    public function __construct(
        private readonly int $max = 100
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->passes($value) === false) {
            $fail('Not a valid :attribute. Must be between 1 - ' . $this->max);
        }
    }

    private function passes(mixed $value): bool
    {
        return is_numeric($value) && $value > 0 && $value <= $this->max;
    }
}
