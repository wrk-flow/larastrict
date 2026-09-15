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

    final public const string TranslationKey = 'exceptions.' . TranslatableException::class;

    public static function data(): array
    {
        return [
            [
                static fn (self $self) => $self->assert(new Exception('Test'), null),
            ],
            [
                static fn (self $self) => $self->assert(
                    new PublicException('should_not_be_visible'),
                    'My message',
                ),
            ],
            [
                static fn (self $self) => $self->assert(new TranslatableException('should_not_be_visible'), 'My message', [], true),
            ],
            [
                static fn (self $self) => $self->assert(
                    new TranslatableException('should_not_be_visible'),
                    '',
                    [
                        ['Missing translation for exception under given key', [
                            'key' => self::TranslationKey,
                        ]],
                    ],
                    false,
                ),
            ],
        ];
    }

    /**
     * @param array<array-key, mixed> $expectedWarningMessages
     */
    public function assert(
        Throwable $exception,
        ?string $expectedResult,
        array $expectedWarningMessages = [],
        ?bool $returnTranslation = null,
    ): void {
        $logger = new Logger();
        $translationKey = self::TranslationKey;
        $translatorAssert = new TranslatorAssert(
            [
                $returnTranslation === null ? null : new TranslatorGetExpectation(
                    $returnTranslation ? 'My message' : $translationKey,
                    $translationKey,
                    [
                        'key' => 'test',
                    ],
                ),
            ],
        );
        $action = new GetPublicExceptionMessageAction(
            new TestingContainer(
                [
                    Translator::class => $translatorAssert,
                    LoggerInterface::class => $logger,
                ],
            ),
        );

        $result = $action->execute($exception);

        $this->assertEquals($expectedResult, $result);
        $this->assertEquals($expectedWarningMessages, $logger->warning);
        $translatorAssert->assertCalled();
    }
}
