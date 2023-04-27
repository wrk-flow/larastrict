<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Translations;

use LaraStrict\Providers\AbstractServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

class AbstractProviderTranslationsTest extends TestCase
{
    public function testNotLoaded(): void
    {
        $this->expectExceptionMessage(sprintf('Provider for <%s> not loaded', TranslationServiceProvider::class));
        $this->app()
            ->make(InvalidServiceProviderTranslations::class);
    }

    public function testNotExtendingAbstractServiceProvider(): void
    {
        $this->app()
            ->register(TranslationServiceProvider::class);

        $this->expectExceptionMessage(
            sprintf(
                'Provider <%s> must use <%s>',
                TranslationServiceProvider::class,
                AbstractServiceProvider::class
            )
        );
        $this->app()
            ->make(InvalidServiceProviderTranslations::class);
    }
}
