<?php

declare(strict_types=1);

namespace LaraStrict\Context\Values;

use LaraStrict\Context\Contracts\ContextValueContract;

class BoolContextValue implements ContextValueContract
{
    public function __construct(
        private readonly bool $is,
    ) {
    }

    public function isValid(): bool
    {
        return $this->is;
    }
}
