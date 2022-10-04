<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Translations;

use LaraStrict\Translations\AbstractProviderTranslations;

class InvalidServiceProviderTranslations extends AbstractProviderTranslations
{
    public function getLocalizationKey(): string
    {
        return 'test';
    }

    protected function getProviderClass(): string
    {
        return TranslationServiceProvider::class;
    }
}
