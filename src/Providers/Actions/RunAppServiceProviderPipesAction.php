<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Actions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

class RunAppServiceProviderPipesAction implements RunAppServiceProviderPipesActionContract
{
    public function __construct(
        private readonly Container $container
    ) {
    }

    public function execute(AppServiceProviderEntity $app, array $pipes): void
    {
        /** @var Pipeline $pipeline */
        $pipeline = $this->container->make(Pipeline::class);

        $pipeline
            ->send($app)
            ->through($pipes)
            ->then(static function () {
            });
    }
}
