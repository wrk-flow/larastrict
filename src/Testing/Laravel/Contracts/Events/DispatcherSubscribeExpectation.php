<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final class DispatcherSubscribeExpectation
{
    public function __construct(
        public readonly mixed $subscriber,
    ) {
    }
}
