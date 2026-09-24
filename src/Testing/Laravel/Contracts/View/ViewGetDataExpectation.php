<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final readonly class ViewGetDataExpectation
{
    /**
     * @param array<array-key, mixed> $return
     */
    public function __construct(
        public array $return,
    ) {
    }
}
