<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final readonly class DispatcherSubscribeExpectation
{
    public function __construct(
        public mixed $subscriber,
    ) {
    }
}
