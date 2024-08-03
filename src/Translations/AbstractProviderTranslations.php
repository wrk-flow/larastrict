<?php

declare(strict_types=1);

namespace LaraStrict\Translations;

use Illuminate\Contracts\Translation\Translator;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Actions\GetAppServiceProviderForClassAction;

abstract class AbstractProviderTranslations extends AbstractTranslations
{
    protected readonly string $providerKey;

    public function __construct(
        Translator $translator,
        GetAppServiceProviderForClassAction $getAppServiceProviderForClassAction,
    ) {
        parent::__construct($translator);

        $appService = $getAppServiceProviderForClassAction->execute($this->getProviderClass());

        $this->providerKey = $appService->serviceName;
    }

    /**
     * @return class-string<AbstractServiceProvider>
     */
    abstract protected function getProviderClass(): string;

    protected function getKey(string|array $key): string
    {
        return $this->providerKey . '::' . parent::getKey($key);
    }
}
