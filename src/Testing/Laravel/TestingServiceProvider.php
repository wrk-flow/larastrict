<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaraStrict\Providers\AbstractServiceProvider;

class TestingServiceProvider extends AbstractServiceProvider
{
    public function __construct(
        Application $app,
        public readonly ServiceProvider|string|null $wrappedProvider = null,
    ) {
        parent::__construct($app);
    }
}
