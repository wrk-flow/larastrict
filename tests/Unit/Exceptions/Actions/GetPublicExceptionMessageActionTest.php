<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Exceptions\Actions;

use Exception;
use Illuminate\Contracts\Translation\Translator;
use LaraStrict\Exceptions\Actions\GetPublicExceptionMessageAction;
use LaraStrict\Testing\Concerns\TestData;
use LaraStrict\Testing\Laravel\Contracts\Translation\TranslatorAssert;
use LaraStrict\Testing\Laravel\Contracts\Translation\TranslatorGetExpectation;
use LaraStrict\Testing\Laravel\Logger;
use LaraStrict\Testing\Laravel\TestingContainer;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Throwable;

class GetPublicExceptionMessageActionTest extends TestCase
{
    use TestData;

    final public const TranslationKey = 'exceptions.' . TranslatableException::class;

    public static function data(): array
    {
        return [
            [
                static fn (self $self) => $self->assert(exception: new Exception('Test'), expectedResult: null),
            ],
            [
                static fn (self $self) => $self->assert(
                    exception: new PublicException('should_not_be_visible'),
                    expectedResult: 'My message',
                ),
            ],
            [
                static fn (self $self) => $self->assert(
                    exception: new TranslatableException('should_not_be_visible'),
                    expectedResult: 'My message',
                    returnTranslation: true,
                ),
            ],
            [
                static fn (self $self) => $self->assert(
                    exception: new TranslatableException('should_not_be_visible'),
                    expectedResult: '',
                    expectedWarningMessages: [
                        ['Missing translation for exception under given key', [
                            'key' => self::TranslationKey,
                        ]],
                    ],
                    returnTranslation: false,
                ),
            ],
        ];
    }

    public function assert(
        Throwable $exception,
        ?string $expectedResult,
        array $expectedWarningMessages = [],
        ?bool $returnTranslation = null,
    ): void {
        $logger = new Logger();
        $translationKey = self::TranslationKey;
        $translatorAssert = new TranslatorAssert(
            get: [
                $returnTranslation === null ? null : new TranslatorGetExpectation(
                    return: $returnTranslation ? 'My message' : $translationKey,
                    key: $translationKey,
                    replace: [
                        'key' => 'test',
                    ],
                ),
            ],
        );
        $action = new GetPublicExceptionMessageAction(
            container: new TestingContainer(
                makeBindings: [
                    Translator::class => $translatorAssert,
                    LoggerInterface::class => $logger,
                ],
            ),
        );

        $result = $action->execute(exception: $exception);

        $this->assertEquals(expected: $expectedResult, actual: $result);
        $this->assertEquals(expected: $expectedWarningMessages, actual: $logger->warning);
        $translatorAssert->assertCalled();
    }
}
