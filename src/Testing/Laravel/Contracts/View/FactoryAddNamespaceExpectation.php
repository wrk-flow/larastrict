<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final class FactoryAddNamespaceExpectation
{
    public function __construct(
        public readonly mixed $namespace,
        public readonly mixed $hints,
    ) {
    }
}
