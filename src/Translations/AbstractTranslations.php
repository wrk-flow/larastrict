<?php

declare(strict_types=1);

namespace LaraStrict\Translations;

use Countable;
use Illuminate\Contracts\Translation\Translator;

/**
 * - Makes translations testable
 * - Forces us making type strict access of translations
 * - Prevent reusing `file` name string (automatically wraps the key)
 */
abstract class AbstractTranslations
{
    public function __construct(
        private readonly Translator $translator
    ) {
    }

    /**
     * Returns localization path (file name)
     */
    abstract public function getLocalizationKey(): string;

    protected function get(string $key, array $replace = [], ?string $locale = null): string
    {
        return $this->translator->get($this->getKey($key), $replace, $locale);
    }

    protected function getArray(string $key, array $replace = [], ?string $locale = null): array
    {
        return $this->translator->get($this->getKey($key), $replace, $locale);
    }

    protected function getChoice(
        string $key,
        int|array|Countable $number,
        array $replace = [],
        ?string $locale = null
    ): string {
        return $this->translator->choice($this->getKey($key), $number, $replace, $locale);
    }

    private function getKey(string $key): string
    {
        return $this->getLocalizationKey() . '.' . $key;
    }
}
