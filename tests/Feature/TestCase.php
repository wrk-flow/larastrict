<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature;

use LaraStrict\Core\LaraStrictServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [LaraStrictServiceProvider::class];
    }
}
