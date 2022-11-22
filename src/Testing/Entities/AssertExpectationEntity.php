<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Entities;

use Closure;

class AssertExpectationEntity
{
    /**
     * @template TAssert
     * @template TResult
     * @param Closure():TAssert $createAssert
     * @param Closure(TAssert):(TResult|void)                               $call
     * @param TResult|null                                 $expectedResult If null is passed then created assert will be used.
     */
    public function __construct(
        public readonly string $methodName,
        public readonly Closure $createAssert,
        public readonly Closure $call,
        public readonly bool $checkResult = false,
        public readonly bool $checkResultIsSelf = false,
        public readonly mixed $expectedResult = null,
    ) {
    }
}
