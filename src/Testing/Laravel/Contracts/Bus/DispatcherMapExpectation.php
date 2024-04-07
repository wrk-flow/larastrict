<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final class DispatcherMapExpectation
{
    public function __construct(
        public readonly array $map,
    ) {
    }
}
