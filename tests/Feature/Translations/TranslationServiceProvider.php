<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Translations;

use LaraStrict\Providers\AbstractServiceProvider;

class TranslationServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'package');
    }
}
