<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Closure;

final readonly class TranslatorGetExpectation
{
    /**
     * @param Closure(mixed, array<array-key, mixed>, mixed, self):void|null $hook
     * @param array<array-key, mixed> $replace
     */
    public function __construct(
        public mixed $return,
        public mixed $key,
        public array $replace = [],
        public mixed $locale = null,
        public ?Closure $hook = null,
    ) {
    }
}
