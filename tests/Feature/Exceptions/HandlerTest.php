<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Translation\Translator;
use LaraStrict\Exceptions\Handler;
use LaraStrict\Testing\Concerns\TestData;
use Tests\LaraStrict\Feature\TestCase;
use Tests\LaraStrict\Unit\Exceptions\Actions\PublicException;
use Tests\LaraStrict\Unit\Exceptions\Actions\TranslatableException;
use Throwable;

class HandlerTest extends TestCase
{
    use TestData;

    public static function data(): array
    {
        return [
            'non http interface returns Server error' => [
                static fn (self $self) => $self->assert(
                    exception: new Exception('Test'),
                    expectedResult: [
                        'message' => 'Server Error',
                    ],
                ),
            ],
            'message exception returns message' => [
                static fn (self $self) => $self->assert(
                    exception: new PublicException('Test'),
                    expectedResult: [
                        'message' => 'My message',
                    ],
                ),
            ],
            'translatable exception returns message' => [
                static fn (self $self) => $self->assert(
                    exception: new TranslatableException('Test'),
                    expectedResult: [
                        'message' => 'My message is a test',
                    ],
                ),
            ],
        ];
    }

    public function assert(Throwable $exception, array $expectedResult): void
    {
        /** @var Translator $translator */
        $translator = $this->app()
            ->make(Translator::class);

        $translator->addLines([
            'exceptions.' . TranslatableException::class => 'My message is a :key',
        ], 'en');

        /** @var Router $router */
        $router = $this->app()
            ->make(Router::class);

        $router->get('/test', static fn () => throw new $exception());

        $this->getJson('/test')
            ->assertJson($expectedResult, true);
    }

    protected function resolveApplicationExceptionHandler($app)
    {
        $app->singleton(ExceptionHandler::class, Handler::class);
    }
}
