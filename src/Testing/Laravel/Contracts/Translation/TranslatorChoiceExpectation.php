<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Closure;

final class TranslatorChoiceExpectation
{
    /**
     * @param Closure(mixed, mixed, array, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly string $return,
        public readonly mixed $key,
        public readonly mixed $number,
        public readonly array $replace = [],
        public readonly mixed $locale = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
