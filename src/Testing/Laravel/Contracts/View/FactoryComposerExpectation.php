<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

final readonly class FactoryComposerExpectation
{
    /**
     * @param array<array-key, mixed> $return
     */
    public function __construct(
        public array $return,
        public mixed $views,
        public mixed $callback,
    ) {
    }
}
