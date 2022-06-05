<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Filesystem;

use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;

class Filesystem implements FilesystemContract
{
    public array $exists;

    /**
     * A map of paths with boolean state if it exists.
     *
     * @var array<bool>
     */
    public array $existsMap = [];

    public function __construct(public readonly string $diskName = 'default')
    {
    }

    public function exists($path)
    {
        return $this->exists[$path] ?? false;
    }

    public function get($path)
    {
        return '/testing/' . $path;
    }

    public function readStream($path)
    {
        return null;
    }

    public function put($path, $contents, $options = [])
    {
        return true;
    }

    public function writeStream($path, $resource, array $options = [])
    {
        return true;
    }

    public function getVisibility($path)
    {
        return 'public';
    }

    public function setVisibility($path, $visibility)
    {
        return true;
    }

    public function prepend($path, $data)
    {
        return true;
    }

    public function append($path, $data)
    {
        return true;
    }

    public function delete($paths)
    {
        return true;
    }

    public function copy($from, $to)
    {
        return true;
    }

    public function move($from, $to)
    {
        return true;
    }

    public function size($path)
    {
        return 0;
    }

    public function lastModified($path)
    {
        return 0;
    }

    public function files($directory = null, $recursive = false): array
    {
        return [];
    }

    public function allFiles($directory = null): array
    {
        return [];
    }

    public function directories($directory = null, $recursive = false): array
    {
        return [];
    }

    public function allDirectories($directory = null): array
    {
        return [];
    }

    public function makeDirectory($path): bool
    {
        return false;
    }

    public function deleteDirectory($directory): bool
    {
        return false;
    }
}
