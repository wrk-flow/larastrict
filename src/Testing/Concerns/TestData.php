<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Closure;

/**
 * Create simple test case with data set and their assert closure
 */
trait TestData
{
    /**
     * @return array<string|int, array{0: Closure():void}>
     */
    abstract public function data(): array;

    /**
     * @dataProvider data
     */
    public function test(Closure $assert): void
    {
        $assert();
    }
}
