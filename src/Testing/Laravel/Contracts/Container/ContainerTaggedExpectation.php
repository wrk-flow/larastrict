<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Container;

final class ContainerTaggedExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $tag,
    ) {
    }
}
