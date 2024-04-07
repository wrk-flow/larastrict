<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Closure;

final class TranslatorGetLocaleExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly string $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
