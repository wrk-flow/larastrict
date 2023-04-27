<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Config\Valid\Config;

use LaraStrict\Config\AbstractProviderConfig;
use Tests\LaraStrict\Feature\Config\Valid\ValidConfigServiceProvider;

class ValidConfig extends AbstractProviderConfig
{
    final public const KeyTest = 'test';

    public function getTest(): string
    {
        return $this->get(self::KeyTest);
    }

    protected function getServiceProvider(): string
    {
        return ValidConfigServiceProvider::class;
    }
}
