<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

trait CreateRequest
{
    /**
     * @template TRequest of Request
     *
     * @param class-string<TRequest> $requestClass
     *
     * @return TRequest
     */
    public function createPostRequest(Application $application, string $requestClass, array $data): object
    {
        $request = new Request(request: $data);
        $request->setMethod('POST');

        $application->instance('request', $request);

        return $application->make($requestClass);
    }
}
