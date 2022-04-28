<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayOrStringRule implements Rule
{
    public function passes($attribute, $value)
    {
        return is_array($value) || is_string($value);
    }

    public function message()
    {
        return 'Given :attribute must by array or string';
    }
}
