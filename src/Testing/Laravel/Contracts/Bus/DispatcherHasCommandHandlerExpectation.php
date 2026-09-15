<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final readonly class DispatcherHasCommandHandlerExpectation
{
    public function __construct(
        public bool $return,
        public mixed $command,
    ) {
    }
}
