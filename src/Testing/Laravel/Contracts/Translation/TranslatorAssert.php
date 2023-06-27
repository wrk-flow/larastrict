<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Translation;

use Countable;
use Illuminate\Contracts\Translation\Translator;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class TranslatorAssert extends AbstractExpectationCallsMap implements Translator
{
    /**
     * @param array<TranslatorGetExpectation|null> $get
     * @param array<TranslatorChoiceExpectation|null> $choice
     * @param array<TranslatorGetLocaleExpectation|null> $getLocale
     * @param array<TranslatorSetLocaleExpectation|null> $setLocale
     */
    public function __construct(array $get = [], array $choice = [], array $getLocale = [], array $setLocale = [])
    {
        parent::__construct();

        $this->setExpectations(TranslatorGetExpectation::class, $get);
        $this->setExpectations(TranslatorChoiceExpectation::class, $choice);
        $this->setExpectations(TranslatorGetLocaleExpectation::class, $getLocale);
        $this->setExpectations(TranslatorSetLocaleExpectation::class, $setLocale);
    }

    /**
     * Get the translation for a given key.
     *
     * @param  string  $key
     * @param  string|null  $locale
     * @return mixed
     */
    public function get($key, array $replace = [], $locale = null)
    {
        $expectation = $this->getExpectation(TranslatorGetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->replace, $replace, $message);
        Assert::assertEquals($expectation->locale, $locale, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $replace, $locale, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Get a translation according to an integer value.
     *
     * @param  string  $key
     * @param Countable|int|array $number
     * @param  string|null  $locale
     * @return string
     */
    public function choice($key, $number, array $replace = [], $locale = null)
    {
        $expectation = $this->getExpectation(TranslatorChoiceExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->number, $number, $message);
        Assert::assertEquals($expectation->replace, $replace, $message);
        Assert::assertEquals($expectation->locale, $locale, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $key, $number, $replace, $locale, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Get the default locale being used.
     *
     * @return string
     */
    public function getLocale()
    {
        $expectation = $this->getExpectation(TranslatorGetLocaleExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Set the default locale.
     *
     * @param  string  $locale
     */
    public function setLocale($locale)
    {
        $expectation = $this->getExpectation(TranslatorSetLocaleExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->locale, $locale, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $locale, $expectation);
        }
    }
}
