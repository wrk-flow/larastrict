<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Context\Services;

use LaraStrict\Context\Contracts\ContextValueContract;

class TestValue implements ContextValueContract
{
    public function __construct(
        public readonly string $value,
    ) {
    }

    public function isValid(): bool
    {
        return true;
    }
}
