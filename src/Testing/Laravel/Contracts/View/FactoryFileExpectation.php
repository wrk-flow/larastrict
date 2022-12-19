<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final class FactoryFileExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $path,
        public readonly mixed $data = [],
        public readonly mixed $mergeData = [],
    ) {
    }
}
