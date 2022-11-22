<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Container;

final class ContainerBeforeResolvingExpectation
{
    public function __construct(
        public readonly mixed $abstract,
        public readonly ?\Closure $callback = null,
    ) {
    }
}
