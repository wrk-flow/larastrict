<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Translations;

use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'package');
    }
}
