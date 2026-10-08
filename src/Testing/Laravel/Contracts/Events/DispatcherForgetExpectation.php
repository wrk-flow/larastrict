<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final readonly class DispatcherForgetExpectation
{
    public function __construct(
        public mixed $event,
    ) {
    }
}
