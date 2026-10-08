<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Closure;

final readonly class TranslatorSetLocaleExpectation
{
    /**
     * @param Closure(mixed, self):void|null $hook
     */
    public function __construct(
        public mixed $locale,
        public ?Closure $hook = null,
    ) {
    }
}
