<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class BooleanRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return in_array($value, [true, false, 'true', 'false', 0, 1, '0', '1'], true);
    }

    public function message(): string
    {
        return 'Given :attribute is not a valid boolean: true, false, 0, 1 (can be string or numeric value).';
    }
}
