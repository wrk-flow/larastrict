<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final readonly class DispatcherChainExpectation
{
    public function __construct(
        public mixed $return,
        public mixed $jobs = null,
    ) {
    }
}
