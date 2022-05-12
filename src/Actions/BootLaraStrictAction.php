<?php

declare(strict_types=1);

namespace LaraStrict\Actions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Entities\AppServiceProviderEntity;
use LaraStrict\Providers\Pipes\PreventLazyLoadingPipe;
use LaraStrict\Providers\Pipes\SetFactoryResolvingProviderPipe;
use LogicException;

class BootLaraStrictAction
{
    public function __construct(
        private readonly RunAppServiceProviderPipesActionContract $runPipesAction
    ) {
    }

    public function execute(Application $application, ServiceProvider $provider): void
    {
        $pipes = [PreventLazyLoadingPipe::class, SetFactoryResolvingProviderPipe::class];

        $dir = realpath(__DIR__ . '/../');

        if ($dir === false) {
            throw new LogicException('Failed to detect LaraStrict boot directory');
        }

        $app = new AppServiceProviderEntity($application, $provider, 'core', $dir);

        $this->runPipesAction->execute($app, $pipes);
    }
}
