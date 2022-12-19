<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final class FactoryComposerExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $views,
        public readonly mixed $callback,
    ) {
    }
}
