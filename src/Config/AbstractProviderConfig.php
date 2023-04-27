<?php

declare(strict_types=1);

namespace LaraStrict\Config;

use Illuminate\Config\Repository;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Actions\GetAppServiceProviderForClassAction;

abstract class AbstractProviderConfig extends AbstractConfig
{
    public function __construct(
        Repository $config,
        private readonly GetAppServiceProviderForClassAction $getAppServiceProviderForClassAction
    ) {
        parent::__construct($config);
    }

    /**
     * @return class-string<AbstractServiceProvider>
     */
    abstract protected function getServiceProvider(): string;

    protected function getConfigFileName(): string
    {
        $appService = $this->getAppServiceProviderForClassAction->execute($this->getServiceProvider());

        return $appService->serviceFileName;
    }
}
