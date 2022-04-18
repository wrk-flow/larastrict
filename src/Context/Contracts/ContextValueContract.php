<?php

declare(strict_types=1);

namespace LaraStrict\Context\Contracts;

interface ContextValueContract
{
    public function isValid(): bool;
}
