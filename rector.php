<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\Config\RectorConfig;

// SKIP laravel
$laravelClasses = [
    __DIR__ . '/src/Testing/Laravel/TestingApplication.php',
    __DIR__ . '/src/Testing/Laravel/TestingContainer.php',
    __DIR__ . '/src/Testing/Laravel/Filesystem/Filesystem.php',
];

return RectorConfig::configure()
    ->withSets([__DIR__.'/vendor/larastrict/conventions/extension-rector.php'])
    ->withRootFiles()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withSkip([
        StaticArrowFunctionRector::class => [__DIR__ . '/src/Log/Managers/ConsoleOutputManager.php'],
        // We want to leave the relative constant path usage
        __DIR__ . '/tests/Feature/Testing/Commands/MakeExpectationCommand/*.php',
    ]);
