<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Closure;

final class TranslatorSetLocaleExpectation
{
    /**
     * @param Closure(mixed, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $locale,
        public readonly ?Closure $hook = null,
    ) {
    }
}
