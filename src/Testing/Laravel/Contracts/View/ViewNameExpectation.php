<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final readonly class ViewNameExpectation
{
    public function __construct(
        public string $return,
    ) {
    }
}
