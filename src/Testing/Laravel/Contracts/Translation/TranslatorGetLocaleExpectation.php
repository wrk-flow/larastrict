<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Closure;

final readonly class TranslatorGetLocaleExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public string $return,
        public ?Closure $hook = null,
    ) {
    }
}
