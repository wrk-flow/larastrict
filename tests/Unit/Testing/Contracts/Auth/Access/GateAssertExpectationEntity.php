<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Contracts\Auth\Access;

use Closure;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateAssert;

class GateAssertExpectationEntity
{
    /**
     * @template TResult
     *
     * @param Closure():GateAssert        $createAssert
     * @param Closure(GateAssert):TResult $call
     * @param TResult|null                $expectedResult If null is passed then created assert will be used.
     */
    public function __construct(
        public readonly string $methodName,
        public readonly Closure $createAssert,
        public readonly Closure $call,
        public readonly mixed $expectedResult,
    ) {
    }
}
