<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final class DispatcherGetCommandHandlerExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $command,
    ) {
    }
}
