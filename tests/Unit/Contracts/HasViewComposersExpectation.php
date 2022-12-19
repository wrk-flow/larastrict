<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Contracts;

use Illuminate\Contracts\View\Factory;

final class HasViewComposersExpectation
{
    public function __construct(
        public readonly string $serviceName,
        public readonly Factory $viewFactory,
    ) {
    }
}
