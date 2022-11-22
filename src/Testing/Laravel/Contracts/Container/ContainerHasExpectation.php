<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Container;

final class ContainerHasExpectation
{
    public function __construct(
        public readonly bool $return,
        public readonly string $id,
    ) {
    }
}
