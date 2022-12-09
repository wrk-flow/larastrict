<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final class DispatcherDispatchSyncExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $command,
        public readonly mixed $handler = null,
    ) {
    }
}
