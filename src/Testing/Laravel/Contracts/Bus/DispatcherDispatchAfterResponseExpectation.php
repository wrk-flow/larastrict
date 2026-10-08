<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final readonly class DispatcherDispatchAfterResponseExpectation
{
    public function __construct(
        public mixed $command,
        public mixed $handler = null,
    ) {
    }
}
