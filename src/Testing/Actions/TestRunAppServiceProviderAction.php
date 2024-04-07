<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;
use PHPUnit\Framework\Assert;

class TestRunAppServiceProviderAction implements RunAppServiceProviderPipesActionContract
{
    public bool $executed = false;

    /**
     * @param non-empty-string $expectedServiceName
     * @param non-empty-string $expectServiceRootDirToEndWith
     */
    public function __construct(
        public readonly array $expectedPipes,
        public readonly string $expectedServiceName,
        public readonly string $expectServiceRootDirToEndWith,
    ) {
    }

    public function execute(AppServiceProviderEntity $appServiceProvider, array $pipes): void
    {
        Assert::assertEquals($this->expectedServiceName, $appServiceProvider->serviceName);
        Assert::assertStringEndsWith($this->expectServiceRootDirToEndWith, $appServiceProvider->serviceRootDir);

        foreach ($pipes as $pipeClass) {
            $implements = class_implements($pipeClass);

            Assert::assertIsIterable($implements, 'Failed to access class ' . $pipeClass);

            Assert::assertArrayHasKey(
                AppServiceProviderPipeContract::class,
                $implements,
                'Pipe <' . $pipeClass . '> must implement ' . AppServiceProviderPipeContract::class
            );
        }

        Assert::assertEquals($this->expectedPipes, $pipes, 'Incorrect boot pipes');
        $this->executed = true;
    }
}
