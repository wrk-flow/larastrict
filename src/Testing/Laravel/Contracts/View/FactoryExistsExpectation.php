<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final readonly class FactoryExistsExpectation
{
    public function __construct(
        public bool $return,
        public mixed $view,
    ) {
    }
}
