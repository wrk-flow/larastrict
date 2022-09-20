<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing;

class TestExpectation
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
