<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Filesystem;

use BackedEnum;
use Illuminate\Contracts\Filesystem\Factory;
use UnitEnum;

class FilesystemManager extends Filesystem implements Factory
{
    public function disk($name = null)
    {
        if ($name instanceof BackedEnum) {
            $name = (string) $name->value;
        } elseif ($name instanceof UnitEnum) {
            $name = $name->name;
        }

        return new Filesystem($name ?? 'local');
    }
}
