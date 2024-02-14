<?php

declare(strict_types=1);

namespace LaraStrict\Translations;

use Illuminate\Contracts\Translation\Translator;
use LaraStrict\Testing\Translations\TestingTranslator;

/**
 * - Makes translations testable
 * - Forces us making type strict access of translations
 * - Prevent reusing `file` name string (automatically wraps the key)
 */
abstract class AbstractTranslations extends AbstractInternalTranslations
{
    final public function __construct(
        private readonly Translator $translator
    ) {
    }

    /**
     * @param array<string, mixed> $returnValueOnKey
     */
    public static function forTests(array $returnValueOnKey = []): static
    {
        return new static(new TestingTranslator($returnValueOnKey));
    }

    protected function getTranslator(): Translator
    {
        return $this->translator;
    }
}
