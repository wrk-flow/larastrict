<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final class ViewWithExpectation
{
    public function __construct(
        public readonly mixed $key,
        public readonly mixed $value = null,
    ) {
    }
}
