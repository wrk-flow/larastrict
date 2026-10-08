<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Config\NotUsingPipe\Config;

use LaraStrict\Config\AbstractProviderConfig;
use Tests\LaraStrict\Feature\Config\NotUsingPipe\NotUsingPipeServiceProvider;

class NotUsingPipeConfig extends AbstractProviderConfig
{
    public function getTest(): string
    {
        $value = $this->get(keyOrPath: ['test', 'sub-key'], default: 'missing file, this is a default');
        assert(is_string($value));
        return $value;
    }

    protected function getServiceProvider(): string
    {
        return NotUsingPipeServiceProvider::class;
    }
}
