<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

use Illuminate\Contracts\View\View;

final readonly class FactoryFileExpectation
{
    public function __construct(
        public View $return,
        public mixed $path,
        public mixed $data = [],
        public mixed $mergeData = [],
    ) {
    }
}
