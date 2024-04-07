<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Filesystem;

use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class Filesystem implements FilesystemContract, Cloud
{
    /**
     * A map of paths with boolean state if it exists.
     *
     * @var array<bool>
     */
    public array $exists = [];

    public function __construct(
        public readonly string $diskName = 'default'
    ) {
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

    public function url($path)
    {
        return 'http://localhost/' . $path;
    }

    /**
     * @todo Remove when dropping support for Laravel 10
     * Get the full path to the file that exists at the given relative path.
     *
     * @param  string  $path
     *
     * @return string
     */
    public function path($path)
    {
        return $path;
    }

    /**
     * @todo Remove when dropping support for Laravel 10
     * Store the uploaded file on the disk.
     *
     * @param File|UploadedFile|string $path
     * @param File|UploadedFile|string|array|null $file
     *
     * @return string|false
     */
    public function putFile($path, $file = null, mixed $options = [])
    {
        return 'the-file';
    }

    /**
     * @todo Remove when dropping support for Laravel 10
     * Store the uploaded file on the disk with a given name.
     *
     * @param File|UploadedFile|string $path
     * @param File|UploadedFile|string|array|null $file
     * @param  string|array|null  $name
     * @return string|false
     */
    public function putFileAs($path, $file, $name = null, mixed $options = [])
    {
        return 'the-file';
    }
}
