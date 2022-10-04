<?php

declare(strict_types=1);

namespace LaraStrict\Translations;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaraStrict\Providers\AbstractServiceProvider;
use LogicException;

abstract class AbstractProviderTranslations extends AbstractTranslations
{
    protected readonly string $providerKey;

    public function __construct(Translator $translator, Application $application)
    {
        parent::__construct($translator);

        // TODO add ability to cache getProvider (laravel patch)
        $providerClass = $this->getProviderClass();
        $serviceProvider = $application->getProvider($providerClass);

        if ($serviceProvider instanceof ServiceProvider === false) {
            throw new LogicException(sprintf('Provider for translation <%s> not loaded ', $providerClass));
        }

        if ($serviceProvider instanceof AbstractServiceProvider === false) {
            throw new LogicException(sprintf(
                'Provider <%s> for translation must use <%s>',
                $providerClass,
                AbstractServiceProvider::class,
            ));
        }

        $this->providerKey = $serviceProvider
            ->getAppServiceProvider()
            ->serviceName;
    }

    /**
     * @return class-string<AbstractServiceProvider>
     */
    abstract protected function getProviderClass(): string;

    protected function getKey(string $key): string
    {
        return $this->providerKey . '::' . parent::getKey($key);
    }
}
