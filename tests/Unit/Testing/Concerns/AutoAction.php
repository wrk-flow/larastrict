<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Concerns;

class AutoAction
{
    public function __construct(
        public readonly string $test,
    ) {
    }
}
