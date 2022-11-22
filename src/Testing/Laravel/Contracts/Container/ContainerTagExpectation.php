<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Container;

final class ContainerTagExpectation
{
    public function __construct(
        public readonly mixed $abstracts,
        public readonly mixed $tags,
    ) {
    }
}
