<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Translations;

use Countable;
use LaraStrict\Testing\Translations\TestingTranslator;
use PHPUnit\Framework\TestCase;

class TestingTranslatorTest extends TestCase
{
    public TestingTranslator $translator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->translator = new TestingTranslator();
    }

    public function testGet(): void
    {
        $this->assertEquals(
            expected: 'test',
            actual: $this->translator->get(key: 'test'),
            message: 'TestingTranslator::get() should return the key as the value',
        );
        $this->assertEquals(
            expected: 'test:r:1,2,3',
            actual: $this->translator->get(key: 'test', replace: [1, 2, 3]),
            message: 'TestingTranslator::get() should return the key as the value with replace',
        );
        $this->assertEquals(
            expected: 'test:l:en',
            actual: $this->translator->get(key: 'test', replace: [], locale: 'en'),
            message: 'TestingTranslator::get() should return the key as the value with locale',
        );
        $this->assertEquals(
            expected: 'test:r:1,2,3:l:en',
            actual: $this->translator->get(key: 'test', replace: [1, 2, 3], locale: 'en'),
            message: 'TestingTranslator::get() should return the key as the value with replace and locale',
        );
    }

    public function testChoice(): void
    {
        $this->assertEquals(
            expected: 'test:1',
            actual: $this->translator->choice(key: 'test', number: 1),
            message: 'TestingTranslator::choice() should return the key as the value',
        );
        $this->assertEquals(
            expected: 'test:40:r:1,2,3',
            actual: $this->translator->choice(key: 'test', number: 40, replace: [1, 2, 3]),
            message: 'TestingTranslator::choice() should return the key as the value with replace',
        );
        $this->assertEquals(
            expected: 'test:30:l:en',
            actual: $this->translator->choice(key: 'test', number: 30, replace: [], locale: 'en'),
            message: 'TestingTranslator::choice() should return the key as the value with locale',
        );
        $this->assertEquals(
            expected: 'test:102:r:1,2,3:l:en',
            actual: $this->translator->choice(key: 'test', number: 102, replace: [1, 2, 3], locale: 'en'),
            message: 'TestingTranslator::choice() should return the key as the value with replace and locale',
        );
    }

    public function testArrayChoice(): void
    {
        $this->assertEquals(
            expected: 'test:1',
            actual: $this->translator->choice(key: 'test', number: [1]),
            message: 'TestingTranslator::choice() should return the key as the value',
        );
        $this->assertEquals(
            expected: 'test:40:r:1,2,3',
            actual: $this->translator->choice(key: 'test', number: [40], replace: [1, 2, 3]),
            message: 'TestingTranslator::choice() should return the key as the value with replace',
        );
        $this->assertEquals(
            expected: 'test:30:l:en',
            actual: $this->translator->choice(key: 'test', number: [30], replace: [], locale: 'en'),
            message: 'TestingTranslator::choice() should return the key as the value with locale',
        );
        $this->assertEquals(
            expected: 'test:102,104:r:1,2,3:l:en',
            actual: $this->translator->choice(key: 'test', number: [102, 104], replace: [1, 2, 3], locale: 'en'),
            message: 'TestingTranslator::choice() should return the key as the value with replace and locale',
        );
    }

    public function testCountableChoice(): void
    {
        $this->assertEquals(
            expected: 'test:1',
            actual: $this->translator->choice(key: 'test', number: new class() implements Countable {
                public function count(): int
                {
                    return 1;
                }
            }),
            message: 'TestingTranslator::choice() should return the key as the value',
        );
        $this->assertEquals(
            expected: 'test:40:r:1,2,3',
            actual: $this->translator->choice(key: 'test', number: new class() implements Countable {
                public function count(): int
                {
                    return 40;
                }
            }, replace: [1, 2, 3]),
            message: 'TestingTranslator::choice() should return the key as the value with replace',
        );
        $this->assertEquals(
            expected: 'test:30:l:en',
            actual: $this->translator->choice(key: 'test', number: new class() implements Countable {
                public function count(): int
                {
                    return 30;
                }
            }, replace: [], locale: 'en'),
            message: 'TestingTranslator::choice() should return the key as the value with locale',
        );
        $this->assertEquals(
            expected: 'test:102:r:1,2,3:l:en',
            actual: $this->translator->choice(key: 'test', number: new class() implements Countable {
                public function count(): int
                {
                    return 102;
                }
            }, replace: [1, 2, 3], locale: 'en'),
            message: 'TestingTranslator::choice() should return the key as the value with replace and locale',
        );
    }

    public function testGetLocale(): void
    {
        $this->assertEquals(
            expected: 'en',
            actual: $this->translator->getLocale(),
            message: 'TestingTranslator::getLocale() should return the default locale',
        );
        $this->translator->setLocale('de');
        $this->assertEquals(
            expected: 'de',
            actual: $this->translator->getLocale(),
            message: 'TestingTranslator::getLocale() should return the set locale',
        );
    }
}
