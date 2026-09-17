<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final readonly class FactoryAddNamespaceExpectation
{
    public function __construct(
        public mixed $namespace,
        public mixed $hints,
    ) {
    }
}
