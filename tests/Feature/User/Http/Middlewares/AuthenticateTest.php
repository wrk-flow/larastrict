<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\User\Http\Middlewares;

use Illuminate\Auth\AuthenticationException;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Testing\Concerns\CreateRequest;
use LaraStrict\Testing\Concerns\TestData;
use LaraStrict\User\Contracts\GetUserForAutoLoginActionContract;
use LaraStrict\User\Http\Middlewares\Authenticate;
use Tests\LaraStrict\Feature\TestCase;
use Tests\LaraStrict\Feature\Testing\Concerns\TestRequest;
use const true;

class AuthenticateTest extends TestCase
{
    use CreateRequest;
    use TestData;

    public function data(): array
    {
        return [
            'empty string' => [
                static fn (self $self) => $self->assert(value: '', expectedValue: '',),
            ],
            'true' => [
                static fn (self $self) => $self->assert(value: true, expectedValue: '1',),
            ],
            'false' => [
                static fn (self $self) => $self->assert(value: false, expectedValue: '',),
            ],
            'true string' => [
                static fn (self $self) => $self->assert(value: 'true', expectedValue: 'true',),
            ],
            'false string' => [
                static fn (self $self) => $self->assert(value: 'false', expectedValue: 'false',),
            ],
            'null' => [
                static fn (self $self) => $self->assert(value: null, expectedValue: null,),
            ],
            'valid but different env - testing' => [
                static fn (self $self) => $self->assert(
                    value: '1',
                    expectedValue: null,
                    environment: EnvironmentType::Testing,
                ),
            ],
            'valid but different env - production' => [
                static fn (self $self) => $self->assert(
                    value: '1',
                    expectedValue: null,
                    environment: EnvironmentType::Production,
                ),
            ],
        ];
    }

    public function assert(
        string|bool|null $value,
        string|null $expectedValue,
        EnvironmentType $environment = EnvironmentType::Local,
    ): void {
        $this->app()
            ->detectEnvironment(static fn () => $environment->value);

        $request = $this->createPostRequest(
            application: $this->app(),
            requestClass: TestRequest::class,
            data: [
                'test' => 'test',
            ],
            server: $value === null ? [] : [
                'HTTP_Auto-Login' => $value,
            ]
        );

        $this->app()
            ->bind(
                GetUserForAutoLoginActionContract::class,
                static fn () => new GetUserForAutoLoginTestAction($expectedValue)
            );

        /** @var Authenticate $middleware */
        $middleware = $this->app()
            ->make(Authenticate::class);

        if ($expectedValue === null) {
            $this->expectException(AuthenticationException::class);
            $middleware->handle($request, static function () {
            });
            return;
        }

        $called = false;
        $middleware->handle($request, static function () use (&$called) {
            $called = true;
        });
        $this->assertEquals(true, $called);
    }
}
