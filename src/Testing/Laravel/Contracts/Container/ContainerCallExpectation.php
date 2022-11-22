<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Container;

final class ContainerCallExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $callback,
        public readonly array $parameters = [],
        public readonly mixed $defaultMethod = null,
    ) {
    }
}
