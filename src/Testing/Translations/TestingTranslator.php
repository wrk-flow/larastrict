<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Translations;

use Illuminate\Contracts\Translation\Translator;

final class TestingTranslator implements Translator
{
    private string $locale = 'en';

    /**
     * @param array<string, mixed> $returnValueOnKey
     */
    public function __construct(
        public array $returnValueOnKey = []
    ) {
    }

    public function get($key, array $replace = [], $locale = null)
    {
        if (array_key_exists($key, $this->returnValueOnKey)) {
            return $this->returnValueOnKey[$key];
        }

        return $this->wrap($key, $replace, $locale);
    }

    public function choice($key, $number, array $replace = [], $locale = null)
    {
        if (array_key_exists($key, $this->returnValueOnKey)) {
            return $this->returnValueOnKey[$key];
        }

        if (is_int($number)) {
            $finalNumber = (string) $number;
        } elseif (is_array($number)) {
            $finalNumber = implode(',', $number);
        } else {
            $finalNumber = (string) count($number);
        }

        return $this->wrap($key . ':' . $finalNumber, $replace, $locale);
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @param array<string|int|float|bool> $replace
     */
    private function wrap(string $value, array $replace = [], string $locale = null): string
    {
        $return = $value;
        if ($replace !== []) {
            $return .= ':r:' . implode(',', $replace);
        }

        if ($locale !== null) {
            $return .= ':l:' . $locale;
        }

        return $return;
    }
}
