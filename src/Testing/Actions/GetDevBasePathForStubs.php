<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Contracts\Foundation\Application;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use LogicException;

class GetDevBasePathForStubs implements GetBasePathForStubsActionContract
{
    public function __construct(
        private readonly Application $application,
    ) {
    }

    public function execute(): string
    {
        // Go to LaraStrict root from orchestra
        $basePath = $this->application->basePath();
        $path = realpath($basePath . '/../../../..');

        if (is_string($path) === false) {
            throw new LogicException('Failed to create dev base path');
        }

        return $path;
    }
}
