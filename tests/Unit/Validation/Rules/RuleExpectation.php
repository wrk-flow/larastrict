<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Validation\Rules;

class RuleExpectation
{
    public function __construct(
        public mixed $value,
        public bool $expectedIsValid,
    ) {
    }
}
