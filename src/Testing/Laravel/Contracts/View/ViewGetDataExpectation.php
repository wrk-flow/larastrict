<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final class ViewGetDataExpectation
{
    public function __construct(
        public readonly array $return,
    ) {
    }
}
