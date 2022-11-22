<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Container;

final class ContainerAddContextualBindingExpectation
{
    public function __construct(
        public readonly mixed $concrete,
        public readonly mixed $abstract,
        public readonly mixed $implementation,
    ) {
    }
}
