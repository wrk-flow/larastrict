<?php declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Filesystem\Filesystem;

final class WritePhpFileAction
{
    public function __construct(private readonly Filesystem $filesystem)
    {
    }


    public function execute(string $directory, string $className, string $content): string
    {
        $filePath = $directory . DIRECTORY_SEPARATOR . $className . '.php';
        $this->filesystem->put($filePath, $content);

        return $filePath;
    }
}
