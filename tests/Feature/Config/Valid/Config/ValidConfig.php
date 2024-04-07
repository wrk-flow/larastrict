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
        $value = $this->get(self::KeyTest);
        assert(is_string($value));
        return $value;
    }

    protected function getServiceProvider(): string
    {
        return ValidConfigServiceProvider::class;
    }
}
