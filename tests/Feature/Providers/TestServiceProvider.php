<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers;

use LaraStrict\Contracts\HasCustomServiceFileName;
use LaraStrict\Contracts\HasTranslations;
use LaraStrict\Contracts\HasViewComponents;
use LaraStrict\Contracts\HasViews;
use LaraStrict\Providers\AbstractServiceProvider;

class TestServiceProvider extends AbstractServiceProvider implements HasTranslations, HasViews, HasViewComponents, HasCustomServiceFileName
{
    public function getServiceFileName(): string
    {
        return 'test_provider';
    }
}
