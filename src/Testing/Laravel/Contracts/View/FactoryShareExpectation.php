<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final readonly class FactoryShareExpectation
{
    public function __construct(
        public mixed $return,
        public mixed $key,
        public mixed $value = null,
    ) {
    }
}
