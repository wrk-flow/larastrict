<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final readonly class ViewRenderExpectation
{
    public function __construct(
        public string $return,
    ) {
    }
}
