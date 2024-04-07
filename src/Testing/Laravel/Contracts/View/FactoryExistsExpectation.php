<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final class FactoryExistsExpectation
{
    public function __construct(
        public readonly bool $return,
        public readonly mixed $view,
    ) {
    }
}
