<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Actions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaraStrict\Cache\Contracts\CacheMeServiceContract;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;
use LogicException;

class GetAppServiceProviderForClassAction
{
    public function __construct(
        private readonly CacheMeServiceContract $cacheMeService,
    ) {
    }

    /**
     * @param class-string<AbstractServiceProvider> $providerClass
     */
    public function execute(string $providerClass): AppServiceProviderEntity
    {
        return $this->cacheMeService->get(
            key: 'app-service-provider-' . $providerClass,
            getValue: static function (Application $application) use ($providerClass) {
                // TODO add ability to cache getProvider (laravel patch)
                $serviceProvider = $application->getProvider($providerClass);
                if ($serviceProvider instanceof ServiceProvider === false) {
                    throw new LogicException(sprintf('Provider for <%s> not loaded ', $providerClass));
                }

                if ($serviceProvider instanceof AbstractServiceProvider === false) {
                    throw new LogicException(sprintf(
                        'Provider <%s> must use <%s>',
                        $providerClass,
                        AbstractServiceProvider::class,
                    ));
                }

                return $serviceProvider->getAppServiceProvider();
            },
            strategy: CacheMeStrategy::Memory
        );
    }
}
