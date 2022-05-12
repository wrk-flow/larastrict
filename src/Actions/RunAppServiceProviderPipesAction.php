<?php

declare(strict_types=1);

namespace LaraStrict\Actions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Entities\AppServiceProviderEntity;

class RunAppServiceProviderPipesAction implements RunAppServiceProviderPipesActionContract
{
    public function __construct(
        private readonly Container $container
    ) {
    }

    public function execute(AppServiceProviderEntity $app, array $pipes): void
    {
        $pipeline = $this->container->make(Pipeline::class);

        $pipeline
            ->send($app)
            ->through($pipes)
            ->then(function () {
            });
    }
}
