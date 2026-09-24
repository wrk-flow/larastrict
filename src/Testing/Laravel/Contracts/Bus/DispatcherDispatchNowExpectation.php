<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final readonly class DispatcherDispatchNowExpectation
{
    public function __construct(
        public mixed $return,
        public mixed $command,
        public mixed $handler = null,
    ) {
    }
}
