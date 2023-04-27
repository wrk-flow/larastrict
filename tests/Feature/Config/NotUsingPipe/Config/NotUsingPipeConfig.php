<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Config\NotUsingPipe\Config;

use LaraStrict\Config\AbstractProviderConfig;
use Tests\LaraStrict\Feature\Config\NotUsingPipe\NotUsingPipeServiceProvider;

class NotUsingPipeConfig extends AbstractProviderConfig
{
    public function getTest(): string
    {
        return $this->get(keyOrPath: ['test', 'sub-key'], default: 'missing file, this is a default');
    }

    protected function getServiceProvider(): string
    {
        return NotUsingPipeServiceProvider::class;
    }
}
