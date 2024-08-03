<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

use Illuminate\Contracts\View\View;

final class FactoryMakeExpectation
{
    public function __construct(
        public readonly View $return,
        public readonly mixed $view,
        public readonly mixed $data = [],
        public readonly mixed $mergeData = [],
    ) {
    }
}
