<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Actions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

final class RunAppServiceProviderPipesAction implements RunAppServiceProviderPipesActionContract
{
    public function __construct(
        private readonly Container $container,
    ) {
    }

    public function execute(AppServiceProviderEntity $appServiceProvider, array $pipes): void
    {
        $pipeline = $this->container->make(Pipeline::class);
        assert($pipeline instanceof Pipeline);

        $pipeline
            ->send($appServiceProvider)
            ->through($pipes)
            ->then(static function () {
            });
    }
}
