<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

use Illuminate\Contracts\View\View;

final readonly class FactoryMakeExpectation
{
    public function __construct(
        public View $return,
        public mixed $view,
        public mixed $data = [],
        public mixed $mergeData = [],
    ) {
    }
}
