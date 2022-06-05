<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Filesystem;

use Illuminate\Contracts\Filesystem\Factory;

class FilesystemManager extends Filesystem implements Factory
{
    public function disk($name = null)
    {
        return new Filesystem($name ?? 'local');
    }
}
