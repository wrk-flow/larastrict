<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class PerPageRule implements Rule
{
    public function __construct(private readonly int $max = 100)
    {
    }

    public function passes($attribute, $value)
    {
        return is_numeric($value) && $value > 0 && $value <= $this->max;
    }

    public function message()
    {
        return 'Not a valid :attribute. Must be between 1 - ' . $this->max;
    }
}
