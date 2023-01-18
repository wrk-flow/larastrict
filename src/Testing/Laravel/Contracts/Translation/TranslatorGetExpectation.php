<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Closure;

final class TranslatorGetExpectation
{
    /**
     * @param Closure(mixed, array, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $key,
        public readonly array $replace = [],
        public readonly mixed $locale = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
