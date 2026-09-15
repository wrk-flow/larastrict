<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Closure;

final readonly class TranslatorChoiceExpectation
{
    /**
     * @param Closure(mixed, mixed, array<array-key, mixed>, mixed, self):void|null $hook
     * @param array<array-key, mixed> $replace
     */
    public function __construct(
        public string $return,
        public mixed $key,
        public mixed $number,
        public array $replace = [],
        public mixed $locale = null,
        public ?Closure $hook = null,
    ) {
    }
}
