<?php

declare(strict_types=1);

namespace LaraStrict\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use LaraStrict\Enums\EnvironmentTypes;

class ForceAcceptJson
{
    public function __construct(
        private readonly Repository $configRepository,
        private readonly Application $application
    ) {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->configRepository->get('app.debug') === false
            || $this->application->environment([EnvironmentTypes::Testing->value]) === true) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
