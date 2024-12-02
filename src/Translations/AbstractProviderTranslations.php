<?php

declare(strict_types=1);

namespace LaraStrict\Translations;

use Illuminate\Contracts\Translation\Translator;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Contracts\GetAppServiceProviderForClassActionContract;
use LaraStrict\Testing\Providers\Actions\GetAppServiceProviderForClassTestAction;
use LaraStrict\Testing\Translations\TestingTranslator;

abstract class AbstractProviderTranslations extends AbstractInternalTranslations
{
    protected readonly string $providerKey;

    final public function __construct(
        private readonly Translator $translator,
        GetAppServiceProviderForClassActionContract $getAppServiceProviderForClassAction
    ) {
        $appService = $getAppServiceProviderForClassAction->execute($this->getProviderClass());

        $this->providerKey = $appService->serviceName;
    }

    /**
     * @param array<string, mixed> $returnValueOnKey
     */
    public static function forTests(array $returnValueOnKey = []): static
    {
        return new static(new TestingTranslator($returnValueOnKey), new GetAppServiceProviderForClassTestAction());
    }

    protected function getTranslator(): Translator
    {
        return $this->translator;
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
