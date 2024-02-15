<?php

declare(strict_types=1);

namespace App\Integration\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand;

final class MultiFunctionContractPhpDocMixedExpectation
{
    /**
     * @param \Closure(mixed,mixed,mixed,self):void|null $_hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $first,
        public readonly mixed $second,
        public readonly mixed $third,
        public readonly ?\Closure $_hook = null,
    ) {
    }
}
