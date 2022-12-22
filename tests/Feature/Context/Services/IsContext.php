<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Context\Services;

use Closure;
use LaraStrict\Context\Contexts\AbstractIsContext;

class IsContext extends AbstractIsContext
{
    public function __construct(
        private readonly int $id,
    ) {
    }

    public function is(): Closure
    {
        return static fn (bool $value): bool => $value;
    }

    public function getCacheKey(): string
    {
        return (string) $this->id;
    }
}
