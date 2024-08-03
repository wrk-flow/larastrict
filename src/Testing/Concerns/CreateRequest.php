<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use LaraStrict\Testing\Laravel\Contracts\Validation\ValidatorMock;
use LaraStrict\Testing\Laravel\TestingContainer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

trait CreateRequest
{
    /**
     * Creates a form request using Laravel container (validation is triggered).
     *
     * @template TRequest of Request
     *
     * @param class-string<TRequest> $requestClass
     * @param array<string, string|int|float|bool> $cookies
     * @param array<string, array<UploadedFile>|UploadedFile> $files
     * @param array<string, string|int|float|bool> $server
     *
     * @return TRequest
     */
    public function createAndValidateRequest(
        Application $application,
        string $requestClass,
        array $data,
        string $accept = 'application/json',
        array $cookies = [],
        array $files = [],
        array $server = [],
    ): object {
        $urlGenerator = $application->make(UrlGenerator::class);
        assert($urlGenerator instanceof UrlGenerator);

        $uri = $urlGenerator->to('');
        $symfonyRequest = SymfonyRequest::create(
            uri: $uri,
            method: 'POST',
            parameters: $data,
            cookies: $cookies,
            files: $files,
            server: [
                ...$server,
                'HTTP_ACCEPT' => $accept,
            ],
        );

        $request = Request::createFromBase($symfonyRequest);

        $application->instance('request', $request);

        return $application->make($requestClass);
    }

    /**
     * Creates a form request without Laravel container (no validation is triggered - acts as validated).
     *
     * @template T of FormRequest
     *
     * @param class-string<T>                                         $requestClass
     * @param array<string, string|int|float|bool>                    $cookies
     * @param array<string, array<UploadedFile>|UploadedFile>         $files
     * @param array<string, string|int|float|bool>                    $server
     * @param array<string, object|Closure(array $makeBindings, class-string $abstract):(object|null)|null> $makeBindings A map of closures that will create.
     * Receives make $parameters and
     * $abstract string
     * @return T
     */
    protected function createFormRequest(
        string $requestClass,
        array $data,
        string $method = 'POST',
        string $accept = 'application/json',
        array $cookies = [],
        array $files = [],
        array $server = [],
        array $makeBindings = [],
        Authenticatable $user = null,
    ): Request {
        $symfonyRequest = SymfonyRequest::create(
            uri: 'https://testing',
            method: $method,
            parameters: $data,
            cookies: $cookies,
            files: $files,
            server: [
                ...$server,
                'HTTP_ACCEPT' => $accept,
            ],
        );

        $request = $requestClass::createFromBase($symfonyRequest);

        $request->setContainer(
            new TestingContainer(
                makeBindings: $makeBindings,
                makeAlwaysBinding: static fn (array $parameters, string $class) => new $class(...$parameters),
            ),
        );

        if ($user instanceof Authenticatable) {
            $request->setUserResolver(static fn () => $user);
        }

        $request->setValidator(new ValidatorMock($data));
        $request->validateResolved();

        return $request;
    }
}
