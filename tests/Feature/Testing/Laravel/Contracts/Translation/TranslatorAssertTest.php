<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\Translation;

use LaraStrict\Testing\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\Translation\TranslatorAssert;
use LaraStrict\Testing\Laravel\Contracts\Translation\TranslatorChoiceExpectation;
use LaraStrict\Testing\Laravel\Contracts\Translation\TranslatorGetExpectation;
use LaraStrict\Testing\Laravel\Contracts\Translation\TranslatorGetLocaleExpectation;
use LaraStrict\Testing\Laravel\Contracts\Translation\TranslatorSetLocaleExpectation;
use PHPUnit\Framework\TestCase;

class TranslatorAssertTest extends TestCase
{
    use AssertExpectations;

    protected function generateData(): array
    {
        return [
            new AssertExpectationEntity(
                methodName: 'get',
                createAssert: static fn () => new TranslatorAssert(get: [new TranslatorGetExpectation(
                    return: 'Test',
                    key: 'test'
                )]),
                call: static fn (TranslatorAssert $assert) => $assert->get(key: 'test'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'get',
                createAssert: static fn () => new TranslatorAssert(get: [new TranslatorGetExpectation(
                    return: 'Test',
                    key: 'test',
                    replace: ['test'],
                    locale: 'cs'
                )]),
                call: static fn (TranslatorAssert $assert) => $assert->get(
                    key: 'test',
                    replace: ['test'],
                    locale: 'cs'
                ),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'choice',
                createAssert: static fn () => new TranslatorAssert(choice: [new TranslatorChoiceExpectation(
                    return: 'Test',
                    key: 'test',
                    number: 1,
                )]),
                call: static fn (TranslatorAssert $assert) => $assert->choice(key: 'test', number: 1),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'choice',
                createAssert: static fn () => new TranslatorAssert(choice: [new TranslatorChoiceExpectation(
                    return: 'Test',
                    key: 'test',
                    number: 1,
                    replace: ['test'],
                    locale: 'cs'
                )]),
                call: static fn (TranslatorAssert $assert) => $assert->choice(
                    key: 'test',
                    number: 1,
                    replace: ['test'],
                    locale: 'cs'
                ),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'getLocale',
                createAssert: static fn () => new TranslatorAssert(getLocale: [new TranslatorGetLocaleExpectation(
                    return: 'en'
                )]),
                call: static fn (TranslatorAssert $assert) => $assert->getLocale(),
                checkResult: true,
                expectedResult: 'en'
            ),
            new AssertExpectationEntity(
                methodName: 'setLocale',
                createAssert: static fn () => new TranslatorAssert(setLocale: [new TranslatorSetLocaleExpectation(
                    locale: 'cs'
                )]),
                call: static fn (TranslatorAssert $assert) => $assert->setLocale(locale: 'cs'),
                checkResult: true,
                expectedResult: null
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new TranslatorAssert();
    }
}
