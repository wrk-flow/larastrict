<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Translations;

use LaraStrict\Translations\AbstractProviderTranslations;
use Tests\LaraStrict\Feature\Providers\TestServiceProvider;

class TestTranslation extends AbstractProviderTranslations
{
    public function getLocalizationKey(): string
    {
        return 'test';
    }

    public function getTest(): string
    {
        return $this->get('test');
    }

    protected function getProviderClass(): string
    {
        return TestServiceProvider::class;
    }
}
