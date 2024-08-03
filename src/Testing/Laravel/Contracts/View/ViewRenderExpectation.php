<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final class ViewRenderExpectation
{
    public function __construct(
        public readonly string $return,
    ) {
    }
}
