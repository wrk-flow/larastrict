<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Closure;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Create simple test case with data set and their assert closure TODO: deprecate
 */
trait TestData
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    abstract static public function data(): array;

    #[DataProvider('data')]
    public function test(Closure $assert): void
    {
        $assert($this);
    }
}
