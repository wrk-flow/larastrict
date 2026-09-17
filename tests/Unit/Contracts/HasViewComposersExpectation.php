<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Contracts;

use Illuminate\Contracts\View\Factory;

final readonly class HasViewComposersExpectation
{
    public function __construct(
        public string $serviceName,
        public Factory $viewFactory,
    ) {
    }
}
