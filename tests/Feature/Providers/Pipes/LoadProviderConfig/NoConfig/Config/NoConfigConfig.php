<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderConfig\NoConfig\Config;

use LaraStrict\Config\AbstractProviderConfig;
use Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderConfig\NoConfig\NoConfigServiceProvider;

class NoConfigConfig extends AbstractProviderConfig
{
    public function getValue(): string
    {
        $value = $this->get(keyOrPath: ['no-key'], default: 'this is default value');
        assert(is_string($value));
        return $value;
    }

    protected function getServiceProvider(): string
    {
        return NoConfigServiceProvider::class;
    }
}
