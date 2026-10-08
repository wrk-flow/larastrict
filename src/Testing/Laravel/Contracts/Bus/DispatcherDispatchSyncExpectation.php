<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final readonly class DispatcherDispatchSyncExpectation
{
    public function __construct(
        public mixed $return,
        public mixed $command,
        public mixed $handler = null,
    ) {
    }
}
