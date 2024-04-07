<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final class FactoryCreatorExpectation
{
    public function __construct(
        public readonly array $return,
        public readonly mixed $views,
        public readonly mixed $callback,
    ) {
    }
}
