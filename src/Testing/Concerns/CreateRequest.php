<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

trait CreateRequest
{
    /**
     * @template TRequest of Request
     *
     * @param class-string<TRequest> $requestClass
     * @param array<string, string|int|float|bool> $cookies
     * @param array<string, array<UploadedFile>|UploadedFile> $files
     * @param array<string, string|int|float|bool> $server
     *
     * @return TRequest
     */
    public function createPostRequest(
        Application $application,
        string $requestClass,
        array $data,
        string $accept = 'application/json',
        array $cookies = [],
        array $files = [],
        array $server = []
    ): object {
        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $application->make(UrlGenerator::class);

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
}
