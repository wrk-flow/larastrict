<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

trait CreateRequest
{
    /**
     * @template TRequest of Request
     *
     * @param class-string<TRequest> $requestClass
     *
     * @return TRequest
     */
    public function createPostRequest(
        Application $application,
        string $requestClass,
        array $data,
        string $accept = 'application/json'
    ): object {
        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $application->make(UrlGenerator::class);

        $uri = $urlGenerator->to('');
        $symfonyRequest = SymfonyRequest::create(
            uri: $uri,
            method: 'POST',
            parameters: $data,
            cookies: [],
            files: [],
            server: [
                'HTTP_ACCEPT' => $accept,
            ],
        );

        $request = Request::createFromBase($symfonyRequest);

        $application->instance('request', $request);

        return $application->make($requestClass);
    }
}
