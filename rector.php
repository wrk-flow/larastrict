<?php

declare(strict_types=1);

use LaraStrict\Conventions\ExtensionFiles;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withSets([ExtensionFiles::Rector])
    ->withRootFiles()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withSkip([
        // We want to leave the relative constant path usage
        __DIR__ . '/tests/Feature/Testing/Commands/MakeExpectationCommand/*.php',
    ]);
